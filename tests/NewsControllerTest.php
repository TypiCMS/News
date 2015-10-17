<?php


class NewsControllerTest extends TestCase
{
    public function testNewsListAndClickOnButtonNew()
    {
        $this->actingAs($this->user)
             ->visit('admin/news')
             ->see('admin/news/create')
             ->click('New')
             ->seePageIs('admin/news/create');
    }

    public function testViewCreatePage()
    {
        $this->actingAs($this->user)
             ->visit('admin/news/create')
             ->see('New news');
    }

    public function testStoreFails()
    {
        $this->actingAs($this->user)
             ->visit('admin/news/create')
             ->type('', 'date')
             ->press('Save')
             ->seePageIs('admin/news/create')
             ->see('alert alert-danger alert-dismissable');
    }

    public function testStoreSuccess()
    {
        $this->actingAs($this->user)
             ->visit('admin/news/create')
             ->type('2015-09-09', 'date')
             // ->type(0, 'exit')
             ->press('Save')
             ->seeInDatabase('news', ['date' => '2015-09-09'])
             ->seePageIs('admin/news');
    }
}
