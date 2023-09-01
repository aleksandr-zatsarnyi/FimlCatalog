<?php

namespace App\Server\dto;

class MoviesDTO {

    private int $id;
    private string $title;
    private int $releaseYear;
    private string $format;
    private array $stars;

    /**
     * @param int $id
     * @param string $title
     * @param int $releaseYear
     * @param string $format
     * @param array $actors
     */
    public function __construct(string $title, int $releaseYear, string $format, array $actors) {
        $this->title = $title;
        $this->releaseYear = $releaseYear;
        $this->format = $format;
        $this->stars = $actors;
    }


    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getReleaseYear(): int {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): void {
        $this->releaseYear = $releaseYear;
    }

    public function getFormat(): string {
        return $this->format;
    }

    public function setFormat(string $format): void {
        $this->format = $format;
    }

    public function getStars(): array {
        return $this->stars;
    }

    public function setStars(array $stars): void {
        $this->stars = $stars;
    }
}