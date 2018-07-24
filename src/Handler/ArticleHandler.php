<?php

namespace App\Handler;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Context;

use App\Entity\Article;

class ArticleHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return array(
            array(
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => Article::class,
                'method' => 'serializeArticleToJson',
            ),
        );
    }

    public function serializeArticleToJson(JsonSerializationVisitor $visitor, Article $article, array $type, Context $context)
    {
        $now = new \Datetime();
        return [
                    'title'   => ucfirst($article->getTitle()),
                    'content' => ucfirst($article->getContent()),
                    'serialized_at' => $now->format('Y-m-d H:i:s')
            ];
    }
}