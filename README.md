# Vue + laravel

此為使用vue+laravel建立的簡易論壇例子


## 首頁
![image](https://github.com/jiahong-blue/forum_example_laravel/blob/master/src/home.jpg)

## 註冊
>使用官方推薦的Passport OAuth 認證，使用JWT取代session，
>於客戶端，使用vuex來管理使用者的資訊

![image](https://github.com/jiahong-blue/forum_example_laravel/blob/master/src/register.gif)

## 發帖
>一般論壇都有的功能，前端使用axios並用header攜帶Authorization，
>向後端請求建立數據

![image](https://github.com/jiahong-blue/forum_example_laravel/blob/master/src/topic.gif)

## 回覆
>一般論壇都有的功能，和發帖一樣的功能，前端使用axios並用header攜帶Authorization，
>向後端請求，建立數據

![image](https://github.com/jiahong-blue/forum_example_laravel/blob/master/src/post.gif)