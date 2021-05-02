<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Microblog;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class MicroBlogController extends AbstractController
{
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $curPage = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 20);
        $data = Microblog::paginate($perPage, ['*'], 'page', $curPage);
        return $response->json(res_data($data));       
    }

    public function store(RequestInterface $request, ResponseInterface $response) 
    {
        $content = $request->input('content', '');
        if (!$content) {
            return $response->json(res_data([], -1, "内容不能为空！"));
        }
        $microblog = new Microblog();
        $microblog->content = $content;
        $microblog->save();
        return $response->json(res_data(null, 0, "新增成功！"));       
    }

    public function update(RequestInterface $request, ResponseInterface $response, int $id) 
    {
        $content = $request->input('content', '');
        if (!$content) {

        }
        $microblog = Microblog::find($id);
        $microblog->content = $content;
        $microblog->save();
        return $response->json(res_data(null, 0, "更新成功！"));       
    }

    public function destroy(ResponseInterface $response, int $id) 
    {
        $item =  Microblog::find($id);
        if (!$item) {
            return $response->json(res_data([], -1, "内容不存在！"));
        }
        $item->delete();
        return $response->json(res_data());       
    }

    
}
