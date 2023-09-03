<?php

use PHPUnit\Framework\TestCase;
use App\Server\infrastructure\repository\MovieRepository;
use App\Server\dto\MoviesDTO;

class MovieRepositoryTest extends TestCase {
    private PDO $db;
    private MovieRepository $repository;

    protected function setUp(): void {
        $this->db = new PDO('sqlite::memory:');
        $this->repository = new MovieRepository($this->db);

        $this->createTestTable();
    }

    protected function tearDown(): void {
        $this->db->exec('DROP TABLE IF EXISTS movies');
    }

    public function testAddMovie() {
        $dto = new MoviesDTO('Test Movie', 2023, 'DVD', ['Actor 1', 'Actor 2']);
        $result = $this->repository->addMovie($dto);

        $this->assertTrue($result);
    }

    public function testGetAllMovies() {
        $this->insertTestMovieData();

        $movies = $this->repository->getAllMovies();

        $this->assertCount(2, $movies);
        $this->assertEquals('Test Movie 1', $movies[0]['title']);
        $this->assertEquals('Test Movie 2', $movies[1]['title']);
    }

    public function testFindByTitle() {
        $this->insertTestMovieData();

        $movies = $this->repository->findByTitle('Test Movie 1');

        $this->assertCount(1, $movies);
        $this->assertEquals('Test Movie 1', $movies[0]['title']);
    }

    public function testDeleteMovie() {
        $this->insertTestMovieData();

        $movies = $this->repository->getAllMovies();
        $movieId = $movies[0]['id'];

        $result = $this->repository->deleteMovie($movieId);

        $this->assertTrue($result);
    }

    private function createTestTable() {
        $this->db->exec('CREATE TABLE IF NOT EXISTS movies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            release_year INT NOT NULL,
            format VARCHAR(20) NOT NULL,
            stars VARCHAR(255) NOT NULL
        )');
    }

    private function insertTestMovieData() {
        $data = [
            ['Test Movie 1', 2022, 'DVD', 'Actor 1, Actor 2'],
            ['Test Movie 2', 2023, 'Blu-ray', 'Actor 3, Actor 4'],
        ];

        $stmt = $this->db->prepare('INSERT INTO movies (title, release_year, format, stars) VALUES (?, ?, ?, ?)');

        foreach ($data as $row) {
            $stmt->execute($row);
        }
    }
}
