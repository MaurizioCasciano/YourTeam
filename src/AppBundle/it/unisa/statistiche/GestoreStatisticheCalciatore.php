<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 20/12/2016
 * Time: 11:46
 */

namespace AppBundle\it\unisa\statistiche;

use AppBundle\it\unisa\partite\PartitaInterface;
use AppBundle\Utility\DB;

class GestoreStatisticheCalciatore
{
    private $db;
    private $conn;
    private static $tabellaStatisticheCalciatore = "statistiche_calciatore";

    public function __construct()
    {
        $this->db = new DB();
        $this->conn = $this->db->connect();
    }

    function __destruct()
    {
        $this->db->close($this->conn);
    }


    /**
     * Inserisce la statistiche nel database.
     * L'effetto dell'esecuzione di questo metodo è l'inserimento nel DB delle statistiche date in input, che andranno a sommarsi a quelle già presenti.
     * @param StatisticheCalciatore $statistiche
     */
    public function inserisciStatistiche(StatisticheCalciatore $statistiche, $nomePartita, $dataPartita, $squadra)
    {
        $statement = $this->conn->prepare(
            "INSERT INTO " . "statistiche_calciatore" .
            "(calciatore,nome_partita,data_partita,squadra,tiri_totali,tiri_porta,falli_fatti,falli_subiti,
            percentuale_passaggi_riusciti,gol_fatti,gol_subiti,assist,ammonizioni,espulsioni) 
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?) 
            ON DUPLICATE KEY UPDATE
                calciatore = VALUES(calciatore),
                nome_partita = VALUES(nome_partita),
                data_partita = VALUES(data_partita),
                squadra = VALUES(squadra),
                tiri_totali = VALUES(tiri_totali),
                tiri_porta = VALUES(tiri_porta),
                falli_fatti = VALUES(falli_fatti),
                falli_subiti = VALUES(falli_subiti),
                percentuale_passaggi_riusciti = VALUES(percentuale_passaggi_riusciti),
                gol_fatti = VALUES(gol_fatti),
                gol_subiti = VALUES(gol_subiti),
                assist = VALUES(assist),
                ammonizioni = VALUES(ammonizioni),
                espulsioni = VALUES(espulsioni)");

        if (!$statement) {
            throw  new \Exception("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $username = $statistiche->getUsernameCalciatore();
        $tiriTotali = (int)$statistiche->getTiriTotali();
        $tiriPorta = (int)$statistiche->getTiriPorta();
        $falliFatti = (int)$statistiche->getFalliFatti();
        $falliSubiti = (int)$statistiche->getFalliSubiti();
        $percentuaòlePassaggiRiusciti = (int)$statistiche->getPercentualePassaggiRiusciti();
        $golFatti = (int)$statistiche->getGolFatti();
        $golSubiti = (int)$statistiche->getGolSubiti();
        $assist = (int)$statistiche->getAssist();
        $ammonizioni = (int)$statistiche->getAmmonizioni();
        $espulsioni = (int)$statistiche->getEspulsioni();

        $statement->bind_param("ssssiiiiiiiiii", $username, $nomePartita, $dataPartita, $squadra, $tiriTotali,
            $tiriPorta, $falliFatti, $falliSubiti, $percentuaòlePassaggiRiusciti, $golFatti,
            $golSubiti, $assist, $ammonizioni, $espulsioni);

        $executed = $statement->execute();
        $statement->close();
        return $executed;
    }

    /**
     * Restituisce le statistiche di un calciatore relativamente ad una partita.
     * @param $usernameCalciatore L'ID del calciatore.
     * @param $partita La partita a cui si riferiscono le statistiche.
     * @return StatisticheCalciatore Le statistiche del calciatore.
     */
    public function getStatisticheCalciatore($usernameCalciatore, $nome, $data, $squadra)
    {
        //var_dump($usernameCalciatore);
        //var_dump($nome);
        //var_dump($data);
        //var_dump($squadra);

        /*EXAMPLE
        // prepare and bind
            $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $firstname, $lastname, $email);
        */
        /*
         * The argument may be one of four types:
            i - integer
            d - double
            s - string
            b - BLOB*/

        if ($statement = $this->conn->prepare(
            "SELECT * 
              FROM statistiche_calciatore 
              WHERE calciatore = ? AND nome_partita = ? AND data_partita = ? AND squadra = ?")
        ) {
            if ($statement->bind_param("ssss", $usernameCalciatore, $nome, $data, $squadra)) {
                if ($executed = $statement->execute()) {
                    if ($result = $statement->get_result()) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $statisticheCalciatore = new StatisticheCalciatore($usernameCalciatore,
                                $row["tiri_totali"], $row["tiri_porta"], $row["falli_fatti"],
                                $row["falli_subiti"], $row["percentuale_passaggi_riusciti"],
                                $row["gol_fatti"], $row["gol_subiti"], $row["assist"],
                                $row["ammonizioni"], $row["espulsioni"], 0);
                            return $statisticheCalciatore;
                        } else {
                            //var_dump($statement);
                            throw new \Exception("Non ci sono statistiche per questo calciatore in questa partita.");
                        }
                    } else {
                        //var_dump($statement);
                        throw new \Exception("Result is false.");
                    }
                } else {
                    //var_dump($statement);
                    throw new \Exception("Statement non eseguito.");
                }
            } else {
                //var_dump($statement);
                throw new \Exception("Statement binding non effettuato.");
            }
        } else {
            //var_dump($statement);
            throw new \Exception("Statement not prepared");
        }
    }

    /**
     * Restituisce le statistiche complessive di un calciatore.
     */
    public
    function getStatisticheComplessiveCalciatore($usernameCalciatore)
    {
        if ($usernameCalciatore == null) throw new \Exception("L'username del calciatore è null.");

        $statement = $this->conn->prepare(
            "SELECT calciatore,
                SUM(tiri_totali) AS tiri_totali,
                SUM(tiri_porta) AS tiri_porta,
                SUM(falli_fatti) AS falli_fatti,
                SUM(falli_subiti) AS falli_subiti,
                (SUM(percentuale_passaggi_riusciti) / COUNT('calciatore')) AS percentuale_passaggi_riusciti,
                SUM(gol_fatti) AS gol_fatti,
                SUM(gol_subiti) AS gol_subiti,
                SUM(assist) AS assist,
                SUM(ammonizioni) AS ammonizioni,
                SUM(espulsioni) AS espulsioni,
                COUNT('calciatore') AS partite_giocate
            FROM
                statistiche_calciatore
            WHERE
                calciatore = ?
            GROUP BY (calciatore);");

        $statement->bind_param("s", $usernameCalciatore);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $statisticheCalciatore = new StatisticheCalciatore($usernameCalciatore, $row["tiri_totali"], $row["tiri_porta"], $row["falli_fatti"], $row["falli_subiti"], $row["percentuale_passaggi_riusciti"], $row["gol_fatti"], $row["gol_subiti"], $row["assist"], $row["ammonizioni"], $row["espulsioni"], $row["partite_giocate"]);
            return $statisticheCalciatore;
        }

        return null;
    }

    /**
     * Restituisce la lista dei calciatori che rispettano i requisiti statistici indicati.
     * @param $minTiriTotali int
     * @param $minTiriPorta int
     * @param $minGolFatti int
     * @param $minGolSubiti int
     * @param $minAssist int
     * @param $minFalliFatti int
     * @param $minFalliSubiti int
     * @param $minPercentualePassaggiRiusciti int
     * @param $minAmmonizioni int
     * @param $minEspulsioni int
     * @param $maxTiriTotali int
     * @param $maxTiriPorta int
     * @param $maxGolFatti int
     * @param $maxGolSubiti int
     * @param $maxAssist int
     * @param $maxFalliFatti int
     * @param $maxFalliSubiti int
     * @param $maxPercentualePassaggiRiusciti int
     * @param $maxAmmonizioni int
     * @param $maxEspulsioni int
     * @return StatisticheCalciatore|null
     */
    public
    function filtraCalciatori($squadra, $minTiriTotali, $minTiriPorta, $minGolFatti, $minGolSubiti, $minAssist,
                              $minFalliFatti, $minFalliSubiti, $minPercentualePassaggiRiusciti,
                              $minAmmonizioni, $minEspulsioni, $maxTiriTotali, $maxTiriPorta,
                              $maxGolFatti, $maxGolSubiti, $maxAssist, $maxFalliFatti, $maxFalliSubiti,
                              $maxPercentualePassaggiRiusciti, $maxAmmonizioni, $maxEspulsioni)
    {
        $calciatori = $this->getCalciatori($squadra);
        //var_dump($calciatori);
        $filtrati = array();

        foreach ($calciatori as $calciatore) {
            if ($calciatore->hasStatistiche()) {
                $statistiche = $calciatore->getStatistiche();

                $tiriTotali = $statistiche->getTiriTotali();
                $tiriPorta = $statistiche->getTiriPorta();
                $falliFatti = $statistiche->getFalliFatti();
                $falliSubiti = $statistiche->getFalliSubiti();
                $percentualePassaggiRiusciti = $statistiche->getPercentualePassaggiRiusciti();
                $golFatti = $statistiche->getGolFatti();
                $golSubiti = $statistiche->getGolSubiti();
                $assist = $statistiche->getAssist();
                $ammonizioni = $statistiche->getAmmonizioni();
                $espulsioni = $statistiche->getEspulsioni();

                /*var_dump($calciatore);
                var_dump($tiriTotali >= $minTiriTotali && $tiriTotali <= $maxTiriTotali);
                var_dump($tiriPorta >= $minTiriPorta && $tiriPorta <= $maxTiriPorta);
                var_dump($golFatti >= $minGolFatti && $golFatti <= $maxGolFatti);
                var_dump($golSubiti >= $minGolSubiti && $golSubiti <= $maxGolSubiti);
                var_dump($assist >= $minAssist && $assist <= $maxAssist);
                var_dump($assist);
                var_dump($minAssist);
                var_dump($maxAssist);


                var_dump($falliFatti >= $minFalliFatti && $falliFatti <= $maxFalliFatti);
                var_dump($falliSubiti >= $minFalliSubiti && $falliSubiti <= $maxFalliSubiti);
                var_dump($percentualePassaggiRiusciti >= $minPercentualePassaggiRiusciti && $percentualePassaggiRiusciti <= $maxPercentualePassaggiRiusciti);
                var_dump($ammonizioni >= $minAmmonizioni && $ammonizioni <= $maxAmmonizioni);
                var_dump($espulsioni >= $minEspulsioni && $espulsioni <= $maxEspulsioni);*/

                if ($tiriTotali >= $minTiriTotali && $tiriTotali <= $maxTiriTotali) {
                    if ($tiriPorta >= $minTiriPorta && $tiriPorta <= $maxTiriPorta) {
                        if ($golFatti >= $minGolFatti && $golFatti <= $maxGolFatti) {
                            if ($golSubiti >= $minGolSubiti && $golSubiti <= $maxGolSubiti) {
                                if ($assist >= $minAssist && $assist <= $maxAssist) {
                                    if ($falliFatti >= $minFalliFatti && $falliFatti <= $maxFalliFatti) {
                                        if ($falliSubiti >= $minFalliSubiti && $falliSubiti <= $maxFalliSubiti) {
                                            if ($percentualePassaggiRiusciti >= $minPercentualePassaggiRiusciti && $percentualePassaggiRiusciti <= $maxPercentualePassaggiRiusciti) {
                                                if ($ammonizioni >= $minAmmonizioni && $ammonizioni <= $maxAmmonizioni) {
                                                    if ($espulsioni >= $minEspulsioni && $espulsioni <= $maxEspulsioni) {
                                                        $filtrati[] = $calciatore;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $filtrati;
    }

    /**
     * Modifica le statistiche del calciatore, sostituendole con quelle passate in input.
     * @param StatisticheCalciatore $statisticheCalciatore
     */
    public
    function modificaStatistiche(StatisticheCalciatore $statistiche, $nomePartita, $dataPartita, $squadra)
    {
        if ($statement = $this->conn->prepare(
            "UPDATE statistiche_calciatore
            SET
                tiri_totali = ?,
                tiri_porta = ?,
                falli_fatti = ?,
                falli_subiti = ?,
                percentuale_passaggi_riusciti = ?,
                gol_fatti = ?,
                gol_subiti = ?,
                assist = ?,
                ammonizioni = ?,
                espulsioni = ?
            WHERE calciatore = ? AND nome_partita = ? AND data_partita = ? AND squadra = ?")
        ) {
            $username = $statistiche->getUsernameCalciatore();
            $tiriTotali = $statistiche->getTiriTotali();
            $tiriPorta = $statistiche->getTiriPorta();
            $falliFatti = $statistiche->getFalliFatti();
            $falliSubiti = $statistiche->getFalliSubiti();
            $percentualePassaggiRiusciti = $statistiche->getPercentualePassaggiRiusciti();
            $golFatti = $statistiche->getGolFatti();
            $golSubiti = $statistiche->getGolSubiti();
            $assist = $statistiche->getAssist();
            $ammonizioni = $statistiche->getAmmonizioni();
            $espulsioni = $statistiche->getEspulsioni();

            if ($statement->bind_param("iiiiiiiiiissss", $tiriTotali, $tiriPorta, $falliFatti, $falliSubiti,
                $percentualePassaggiRiusciti, $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni,
                $username, $nomePartita, $dataPartita, $squadra)
            ) {
                if ($executed = $statement->execute()) {
                    return $executed;
                } else {
                    throw new \Exception("Statement non eseguito.");
                }
            } else {
                throw new \Exception("Statement binding non eseguito.");
            }
        } else {
            throw new \Exception("Statement prepare non eseguito.");
        }
    }

    /**
     *Restituisce l'elenco dei calciatori della squadra, con le loro statistiche complessive.
     * @param $squadra string La squadra dei calciatori.
     */
    public
    function getCalciatori($squadra)
    {
        $calciatori = array();

        if ($statement = $this->conn->prepare("
            SELECT * FROM calciatore
            WHERE squadra = ?")
        ) {
            $statement->bind_param("s", $squadra);
            if ($statement->execute()) {
                $result = $statement->get_result();

                while ($row = $result->fetch_assoc()) {
                    $contratto = $row["contratto"];
                    $password = $row["password"];
                    $squadra = $row["squadra"];
                    $email = $row["email"];
                    $nome = $row["nome"];
                    $cognome = $row["cognome"];
                    $dataDiNascita = $row["datadinascita"];
                    $numeroMaglia = $row["numeromaglia"];
                    $domicilio = $row["domicilio"];
                    $indirizzo = $row["indirizzo"];
                    $provincia = $row["provincia"];
                    $telefono = $row["telefono"];
                    $immagine = $row["immagine"];

                    $calciatore = new Calciatore($contratto, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $numeroMaglia, $domicilio, $indirizzo, $provincia, $telefono, $immagine);
                    $statisticheCalciatore = $this->getStatisticheComplessiveCalciatore($contratto);
                    $calciatore->setStatistiche($statisticheCalciatore);

                    $calciatori[] = $calciatore;
                }

                return $calciatori;
            } else {
                throw new \Exception("Statement not executed.");
            }
        } else {
            throw new \Exception("Statement not prepared.");
        }
    }

    public
    function getCalciatore($contratto)
    {
        if ($statement = $this->conn->prepare("
            SELECT * FROM calciatore
            WHERE contratto = ?")
        ) {
            if ($statement->bind_param("s", $contratto)) {

                if ($statement->execute()) {
                    $result = $statement->get_result();

                    if ($row = $result->fetch_assoc()) {
                        $contratto = $row["contratto"];
                        $password = $row["password"];
                        $squadra = $row["squadra"];
                        $email = $row["email"];
                        $nome = $row["nome"];
                        $cognome = $row["cognome"];
                        $dataDiNascita = $row["datadinascita"];
                        $numeroMaglia = $row["numeromaglia"];
                        $domicilio = $row["domicilio"];
                        $indirizzo = $row["indirizzo"];
                        $provincia = $row["provincia"];
                        $telefono = $row["telefono"];
                        $immagine = $row["immagine"];

                        $calciatore = new Calciatore($contratto, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $numeroMaglia, $domicilio, $indirizzo, $provincia, $telefono, $immagine);
                        $statisticheCalciatore = $this->getStatisticheComplessiveCalciatore($contratto);
                        $calciatore->setStatistiche($statisticheCalciatore);
                        return $calciatore;
                    } else {
                        throw new \Exception("Calciatore " . $contratto . " non trovato.");
                    }
                } else {
                    throw new \Exception("Errore nell'esecuzione dello statement.");
                }
            } else {
                throw new \Exception("Errore nel legare il parametro allo statement.");
            }
        } else {
            throw new \Exception("Errore nella preparazione dello statement.");
        }
    }

    /**
     * Imposta a 0 il numero di gol fatti nella partita per i calciatori non presenti tra i nuovi marcatori.
     * @param $nuoviMarcatori array L'id dei nuovi marcatori.
     * @param PartitaInterface $partita La partita.
     */
    public function rimuoviMarcatori(PartitaInterface $partita)
    {
        if ($statement = $this->conn->prepare("
        UPDATE statistiche_calciatore
        SET gol_fatti = 0
        WHERE nome_partita = ? AND data_partita = ? AND squadra = ?")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getData();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    return true;
                } else {
                    throw new \Exception("Statement execution non eseguita.");
                }
            } else {
                throw new \Exception("Statement binding non eseguito.");
            }
        } else {
            throw new \Exception("Statement prepare non eseguito.");
        }
    }

    public function rimuoviAssistMen(PartitaInterface $partita)
    {
        if ($statement = $this->conn->prepare("
        UPDATE statistiche_calciatore
        SET assist = 0
        WHERE nome_partita = ? AND data_partita = ? AND squadra = ?")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getData();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    return true;
                } else {
                    throw new \Exception("Statement execution non eseguita.");
                }
            } else {
                throw new \Exception("Statement binding non eseguito.");
            }
        } else {
            throw new \Exception("Statement prepare non eseguito.");
        }
    }

    public function rimuoviAmmonizioni(PartitaInterface $partita)
    {
        if ($statement = $this->conn->prepare("
        UPDATE statistiche_calciatore
        SET ammonizioni = 0
        WHERE nome_partita = ? AND data_partita = ? AND squadra = ?")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getData();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    return true;
                } else {
                    throw new \Exception("Statement execution non eseguita.");
                }
            } else {
                throw new \Exception("Statement binding non eseguito.");
            }
        } else {
            throw new \Exception("Statement prepare non eseguito.");
        }
    }

    public function rimuoviEspulsioni(PartitaInterface $partita)
    {
        if ($statement = $this->conn->prepare("
        UPDATE statistiche_calciatore
        SET espulsioni = 0
        WHERE nome_partita = ? AND data_partita = ? AND squadra = ?")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getData();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    return true;
                } else {
                    throw new \Exception("Statement execution non eseguita.");
                }
            } else {
                throw new \Exception("Statement binding non eseguito.");
            }
        } else {
            throw new \Exception("Statement prepare non eseguito.");
        }
    }
}