<?php
/**
 * ==========================================================
 * Smart Academic Profile
 * Database Connection (PDO)
 * PHP Native 8
 * ==========================================================
 */

require_once __DIR__ . '/config.php';

/*
|--------------------------------------------------------------------------
| Database Configuration
|--------------------------------------------------------------------------
*/

define('DB_HOST', 'localhost');
define('DB_NAME', 'smart_academic_profile');
define('DB_USER', 'root');
define('DB_PASS', '');

/*
|--------------------------------------------------------------------------
| Database Class
|--------------------------------------------------------------------------
*/

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        try {

            $dsn = "mysql:host=" . DB_HOST .
                   ";dbname=" . DB_NAME .
                   ";charset=utf8mb4";

            $this->conn = new PDO(
                $dsn,
                DB_USER,
                DB_PASS
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->conn->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            $this->conn->setAttribute(
                PDO::ATTR_EMULATE_PREPARES,
                false
            );

        } catch (PDOException $e) {

            die("
            <h2>Database Connection Failed</h2>

            <strong>Error :</strong>

            " . $e->getMessage());

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Singleton
    |--------------------------------------------------------------------------
    */

    public static function connect()
    {

        if (self::$instance == null) {

            self::$instance = new Database();

        }

        return self::$instance->conn;

    }

}

/*
|--------------------------------------------------------------------------
| Create Connection
|--------------------------------------------------------------------------
*/

$db = Database::connect();

/*
|--------------------------------------------------------------------------
| Helper Function
|--------------------------------------------------------------------------
*/

/**
 * SELECT
 */
function select($sql, $params = [])
{
    global $db;

    $stmt = $db->prepare($sql);

    $stmt->execute($params);

    return $stmt->fetchAll();
}

/**
 * SELECT ONE
 */

function selectOne($sql, $params = [])
{
    global $db;

    $stmt = $db->prepare($sql);

    $stmt->execute($params);

    return $stmt->fetch();
}

/**
 * INSERT UPDATE DELETE
 */

function execute($sql, $params = [])
{
    global $db;

    $stmt = $db->prepare($sql);

    return $stmt->execute($params);
}

/**
 * COUNT
 */

function countData($table)
{
    global $db;

    $stmt = $db->query("SELECT COUNT(*) as total FROM $table");

    return $stmt->fetch()['total'];
}

/**
 * Last Insert ID
 */

function lastInsertId()
{
    global $db;

    return $db->lastInsertId();
}

/**
 * Check Data Exists
 */

function exists($table, $column, $value)
{
    global $db;

    $stmt = $db->prepare("SELECT COUNT(*) as total FROM $table WHERE $column=?");

    $stmt->execute([$value]);

    return $stmt->fetch()['total'] > 0;
}

/**
 * Begin Transaction
 */

function beginTransaction()
{
    global $db;

    $db->beginTransaction();
}

/**
 * Commit
 */

function commit()
{
    global $db;

    $db->commit();
}

/**
 * Rollback
 */

function rollback()
{
    global $db;

    $db->rollBack();
}