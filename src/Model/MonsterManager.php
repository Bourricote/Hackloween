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
class MonsterManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'monster';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $monster
     * @return int
     */
    public function insert(array $monster): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`name`, `description`, `picture`, `level`, `score`) 
VALUES (:name, :description, :picture, :level, :score)");
        $statement->bindValue('name', $monster['name'], \PDO::PARAM_STR);
        $statement->bindValue('description', $monster['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $monster['picture'], \PDO::PARAM_STR);
        $statement->bindValue('level', $monster['level'], \PDO::PARAM_INT);
        $statement->bindValue('score', $monster['score'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
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
     * @param array $monster
     * @return bool
     */
    public function update(array $monster): bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table 
            SET `name` = :name, `description` = :description, `picture` = :picture, `level` = :level, `score` = :score 
            WHERE id=:id");
        $statement->bindValue('id', $monster['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $monster['name'], \PDO::PARAM_STR);
        $statement->bindValue('description', $monster['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $monster['picture'], \PDO::PARAM_STR);
        $statement->bindValue('level', $monster['level'], \PDO::PARAM_INT);
        $statement->bindValue('score', $monster['score'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function updateScore($monster)
    {
        $statement = $this->pdo->prepare("UPDATE $this->table 
            SET score = score + " . $monster['monster_points'] . " WHERE id = :id");
        $statement->bindValue('id', $monster['monster_id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
