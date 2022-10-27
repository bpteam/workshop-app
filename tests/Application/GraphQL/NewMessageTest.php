<?php

namespace AppName\Tests\Application\GraphQL;

class NewMessageTest extends AbstractWebTestCase
{
    public function testMutationCreateMessage(): void
    {
        $client = static::createGraphQLClient(
            '01GGC9X58HD1S2DV31Q4AMP0J3',
            '123',
            ['marketing'],
        );

        $query = <<<'GQL'
mutation($input: CreateMessageInput!) {
    createMessage(input: $input) {
        id
        text
        dateCreatedAt
        dateUpdateAt
    }
}
GQL;
        $expected = 'hello world';

        $variables = [
            'input' => [
                'text' => 'hello world',
            ],
        ];

        $client->request(
            'POST',
            '/graphql',
            content: json_encode(['query' => $query, 'variables' => $variables]),
        );

        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($expected, $response['data']['createMessage']['text']);
    }
}
