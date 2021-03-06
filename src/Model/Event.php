<?php

declare(strict_types=1);

namespace Gitlab\Model;

use Gitlab\Client;

/**
 * @deprecated since version 10.1 and will be removed in 11.0.
 *
 * @property string    $title
 * @property int       $id
 * @property string    $action_name
 * @property string    $data
 * @property int       $target_id
 * @property string    $target_type
 * @property string    $target_title
 * @property int       $author_id
 * @property string    $author_username
 * @property User|null $author
 * @property Project   $project
 */
final class Event extends AbstractModel
{
    /**
     * @var string[]
     */
    protected static $properties = [
        'title',
        'project_id',
        'action_name',
        'target_id',
        'target_type',
        'author_id',
        'author_username',
        'data',
        'target_title',
        'author',
        'project',
    ];

    /**
     * @param Client  $client
     * @param Project $project
     * @param array   $data
     *
     * @return Event
     */
    public static function fromArray(Client $client, Project $project, array $data)
    {
        $event = new self($project, $client);

        if (isset($data['author_id'])) {
            $data['author'] = new User($data['author_id'], $client);
        }

        return $event->hydrate($data);
    }

    /**
     * @param Project     $project
     * @param Client|null $client
     *
     * @return void
     */
    public function __construct(Project $project, Client $client = null)
    {
        parent::__construct();
        $this->setClient($client);
        $this->setData('project', $project);
    }
}
