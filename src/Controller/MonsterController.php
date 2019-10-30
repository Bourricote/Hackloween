<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\MonsterManager;

/**
 * Class MonsterController
 *
 */
class MonsterController
{


    /**
     * Retrieve monster listing
     *
     * @return string
     */
    public function all()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $monsterManager = new MonsterManager();
            $monsters = $monsterManager->selectAll();

            return json_encode($monsters);
        }
        header('HTTP/1.1 405 Method Not Allowed');
    }


    /**
     * Retrieve monster informations specified by $id
     *
     * @param int $id
     * @return string
     */
    public function show(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $monsterManager = new MonsterManager();
            $monster = $monsterManager->selectOneById($id);

            return json_encode($monster);
        }
        header('HTTP/1.1 405 Method Not Allowed');
    }


    /**
     * Edit monster by $id
     *
     * @param int $id
     */
    public function edit(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            try {
                $monsterManager = new MonsterManager();
                $monster = $monsterManager->selectOneById($id);
                $json = file_get_contents('php://input');
                $obj = json_decode($json);
                $monster['name'] = $obj->name;
                $monster['description'] = $obj->description;
                $monster['picture'] = $obj->picture;
                $monster['level'] = $obj->level;
                $monster['score'] = $obj->score;
                $monsterManager->update($monster);
                header('HTTP/1.1 204 resource updated successfully');
            } catch (\Exception $e) {
                /* var_dump should be delete in production */
                var_dump($e->getMessage());
                header('HTTP/1.1 500 Internal Server Error');
            }
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
        }
    }


    /**
     * post new monster
     *
     * @return string
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $json = file_get_contents('php://input');
                $obj = json_decode($json);
                $monsterManager = new MonsterManager();
                $monster = [
                    'name' => $obj->name,
                    'description' => $obj->description,
                    'picture' => $obj->picture,
                    'level' => $obj->level,
                    'score' => $obj->score,
                ];
                $id = $monsterManager->insert($monster);
                header('HTTP/1.1 201 Created');
                return json_encode(['id' => $id]);
            } catch (\Exception $e) {
                /* var_dump should be delete in production */
                var_dump($e->getMessage());
                header('HTTP/1.1 500 Internal Server Error');
            }
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
        }
    }


    /**
     * Handle monster deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            try {
                $monsterManager = new MonsterManager();
                $monsterManager->delete($id);
                header('HTTP/1.1 204 resource deleted successfully');
            } catch (\Exception $e) {
                /* var_dump should be delete in production */
                var_dump($e->getMessage());
                header('HTTP/1.1 500 Internal Server Error');
            }
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
        }
    }
}
