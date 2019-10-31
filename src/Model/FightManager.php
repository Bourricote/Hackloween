<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class FightManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'fight';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $fight
     * @return int
     */
    public function insert(array $fight): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table
           (monster_id, hunter_id, date, monster_points, hunter_points) 
           VALUES (:monster_id, :hunter_id , :date, :monster_points, :hunter_points)");
        $statement->bindValue('monster_id', $fight['monster_id'], \PDO::PARAM_INT);
        $statement->bindValue('hunter_id', $fight['hunter_id'], \PDO::PARAM_INT);
        $statement->bindValue('date', $fight['date'], \PDO::PARAM_STR);
        $statement->bindValue('monster_points', $fight['monster_points'], \PDO::PARAM_INT);
        $statement->bindValue('hunter_points', $fight['hunter_points'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * Get all row from database.
     *
     * @param int $id
     * @return array
     */
    public function selectAllByHunterId(int $id): array
    {
        $statement = $this->pdo->prepare('SELECT DATE_FORMAT(fight.date, "%d/%m/%Y") AS date, monster.name as monster_name, fight.hunter_points, fight.monster_points 
            FROM ' . $this->table . ' JOIN monster 
            ON monster.id=fight.monster_id WHERE hunter_id=:id ORDER BY date DESC');
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $fight
     * @return bool
     */
    public function update(array $fight):bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $fight['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $fight['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
