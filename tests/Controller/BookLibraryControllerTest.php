<?php

namespace App\Test\Controller;

use App\Entity\BookLibrary;
use App\Repository\BookLibraryRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookLibraryControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private BookLibraryRepository $repository;
    private string $path = '/book/library/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(BookLibrary::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('BookLibrary index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'book_library[isAvailable]' => 'Testing',
            'book_library[book]' => 'Testing',
            'book_library[library]' => 'Testing',
        ]);

        self::assertResponseRedirects('/book/library/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new BookLibrary();
        $fixture->setIsAvailable('My Title');
        $fixture->setBook('My Title');
        $fixture->setLibrary('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('BookLibrary');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new BookLibrary();
        $fixture->setIsAvailable('My Title');
        $fixture->setBook('My Title');
        $fixture->setLibrary('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'book_library[isAvailable]' => 'Something New',
            'book_library[book]' => 'Something New',
            'book_library[library]' => 'Something New',
        ]);

        self::assertResponseRedirects('/book/library/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIsAvailable());
        self::assertSame('Something New', $fixture[0]->getBook());
        self::assertSame('Something New', $fixture[0]->getLibrary());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new BookLibrary();
        $fixture->setIsAvailable('My Title');
        $fixture->setBook('My Title');
        $fixture->setLibrary('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/book/library/');
    }
}
