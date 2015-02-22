<?php
use TypiCMS\Modules\News\Models\News;

class NewsControllerTest extends TestCase
{

    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/news');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreFails()
    {
        $input = ['date' => ''];
        $this->call('POST', 'admin/news', $input);
        $this->assertRedirectedToRoute('admin.news.create');
        $this->assertSessionHasErrors(['date']);
    }

    public function testStoreSuccess()
    {
        $object = new News;
        $object->id = 1;
        News::shouldReceive('create')->once()->andReturn($object);
        $input = array('date' => '2014-03-10 11:04:00');
        $this->call('POST', 'admin/news', $input);
        $this->assertRedirectedToRoute('admin.news.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new News;
        $object->id = 1;
        News::shouldReceive('create')->once()->andReturn($object);
        $input = array('date' => '2014-03-10 11:04:00', 'exit' => true);
        $this->call('POST', 'admin/news', $input);
        $this->assertRedirectedToRoute('admin.news.index');
    }

}
