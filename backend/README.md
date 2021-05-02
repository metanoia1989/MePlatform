# 后端项目
基于 kyperfy 框架，运行方式
```sh
$ php bin/hyperf.php start
然后访问`http://localhost:9501/`即可    
```

nginx 反代理设置，设置之后就可以通过 <http://www.custom-domain.com/api/> 来访问后端API了    
```conf
location /api/ {
    rewrite /api/(.*) /$1 break;
    # 执行代理访问真实服务器
    proxy_redirect off;
    proxy_pass http://localhost:9501;
    # 将客户端的 Host 和 IP 信息一并转发到对应节点  
    proxy_set_header Host $http_host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    # 转发Cookie，设置 SameSite
    proxy_cookie_path / "/; secure; HttpOnly; SameSite=strict";
}
```
