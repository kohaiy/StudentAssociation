# main-server
系统主部分的服务器端

## how to run
```bash
npm install

npm run dev
```

登录实际是对应的资源是 session，因此
- GET /session # 获取会话信息 
- POST /session # 创建新的会话（登录）
- PUT /session # 更新会话信息 
- DELETE /session # 销毁当前会话（注销） 

而注册对应的资源是user，api如下： 
- GET /user/:id # 获取id用户的信息 
- POST /user # 创建新的用户（注册） 
- PUT /user/:id # 更新id用户的信息 
- DELETE /user/:id # 删除id用户（注销）