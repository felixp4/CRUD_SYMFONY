<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{

    public function testIndexAction()
    {
        $client = static::createClient([],
            [
                'PHP_AUTH_USER' => 'ryan',
                'PHP_AUTH_PW' => 'ryanpass',
            ]);

        $crawler = $client->request('GET', '/article');

        // есть надпись "Список объектов" в заголовке страницы
        $this->assertContains('Список объектов', $crawler->filter('body > h1')->text());

        // в таблице 4 строки и 20 ячеек
        $this->assertCount(4, $crawler->filter('body > table > tbody > tr'));
        $this->assertCount(20, $crawler->filter('body > table > tbody > tr > td'));
    }

    public function testCreateAction()
    {
        $client = static::createClient([],
            [
                'PHP_AUTH_USER' => 'ryan',
                'PHP_AUTH_PW' => 'ryanpass',
            ]);
        //$crawler = $client->request('GET','/article');
        //$linkCreate = $crawler->filter('body > a')->link();
        //$crawler = $client->click($linkCreate);

        $crawler = $client->request('GET','/article/create');

        $form = $crawler->selectButton('article[save]')->form();
        $form['article[name]'] = 'test 555';
        $form['article[description]'] = 'testing 555';
        $client->submit($form);

        // в таблице 5 строк и 25 ячеек
        $crawler = $client->request('GET', '/article');
        $this->assertCount(5, $crawler->filter('body > table > tbody > tr'));
        $this->assertCount(25, $crawler->filter('body > table > tbody > tr > td'));

        // в таблице есть созданная строка
        $this->assertContains('test 555', $crawler->filter('body > table > tbody')->text());
        $this->assertContains('testing 555', $crawler->filter('body > table > tbody')->text());
    }

    public function testUpdateAction()
    {
        $client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => 'ryan',
                'PHP_AUTH_PW' => 'ryanpass',
            ]
        );

        $crawlerStart = $client->request('GET', '/article');
        $linkUpdate = $crawlerStart->filter('tr:contains("test 555")')
            ->children()
            ->filter('a:contains("Update")')
            ->link();

        $crawler = $client->request('GET', $linkUpdate->getUri());

        $form = $crawler->selectButton('article[save]')->form();
        $form['article[name]'] = 'test 777';
        $form['article[description]'] = 'testing 777';
        $client->submit($form);

        $crawler = $client->request('GET', '/article');

        // в таблице 5 строк и 25 ячеек
        $this->assertCount(5, $crawler->filter('body > table > tbody > tr'));
        $this->assertCount(25, $crawler->filter('body > table > tbody > tr > td'));

        // в таблице есть обновленная строка
        $this->assertContains('test 777', $crawler->filter('body > table > tbody')->text());
        $this->assertContains('testing 777', $crawler->filter('body > table > tbody')->text());
    }

    public function testDeleteAction()
    {
        $client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => 'ryan',
                'PHP_AUTH_PW' => 'ryanpass',
            ]
        );

        $crawlerStart = $client->request('GET', '/article');
        $linkDelete = $crawlerStart->filter('tr:contains("test 777")')
            ->children()
            ->filter('a:contains("Delete")')
            ->link();

        $client->request('GET', $linkDelete->getUri());

        $crawler = $client->request('GET', '/article');

        // в таблице 4 строки и 20 ячеек
        $this->assertCount(4, $crawler->filter('body > table > tbody > tr'));
        $this->assertCount(20, $crawler->filter('body > table > tbody >tr > td'));

        // в таблице нет обновленной строки (удалена)
        $this->assertNotContains('test 777', $crawler->filter('body > table > tbody')->text());
        $this->assertNotContains('testing 777', $crawler->filter('body > table > tbody')->text());
    }

    public function testAdminAction()
    {
        $client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW' => 'kitten',
            ]
        );

        // на странице есть фраза
        $crawler = $client->request('GET', '/admin');
        $this->assertContains('Admin page!', $crawler->filter('body')->text());
    }
}
