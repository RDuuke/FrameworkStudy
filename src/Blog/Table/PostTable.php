<?php
namespace App\Blog\Table;

class PostTable
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findPaginated()
    {
        return $this->pdo->query("SELECT * FROM posts ORDER BY create_at DESC LIMIT 10")
            ->fetchAll();
    }

    public function find($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }
}