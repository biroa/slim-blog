<?php

declare(strict_types=1);

namespace MarkdownBlog\Entity;

use DateTime;
use Michelf\MarkdownExtra;

class BlogItem
{
    private DateTime $publishDate;
    private string $slug = '';
    private string $title = '';
    private string $image = '';
    private string $synopsis = '';
    private string $content = '';
    private array $categories = [];
    private array $tags = [];

    /**
     * @throws \Exception
     */
    public function __construct(array $options = [])
    {
        $this->populate($options);
    }

    /**
     * @throws \Exception
     */
    public function populate(array $options = []): void
    {
        $properties = get_class_vars(__CLASS__);
        foreach ($options as $key => $value) {
            if (array_key_exists($key, $properties) && !empty($value)) {
                $this->$key = ($key === 'publishDate')
                    ? new DateTime($value)
                    : $value;
            }
        }
    }

    public function getPublishDate(): DateTime
    {
        return $this->publishDate;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        $markdownParser = new MarkdownExtra();
        return $markdownParser->defaultTransform($this->content);
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getSynopsis(): string
    {
        return $this->synopsis ?? '';
    }
}
