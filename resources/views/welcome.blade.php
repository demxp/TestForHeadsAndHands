<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: block;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                width: 50%;
                margin: 20px auto;
            }

            .title {
                font-size: 24px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .reqtoken{
                text-align: left;
                border: 1px solid gray;
                padding: 10px;                
            }

            .content input{
                width:100%;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height" id="vueapp">
            <div class="content">
                <div class="title m-b-md">
                    Тестирование
                </div>

                <div>
                    <div class="reqtoken">
                        <h4>Запрос токена авторизации</h4>
                        <label>Логин</label>
                        <br />
                        <input type="text" v-model="user.login" />
                        <br />
                        <label>Пароль</label>
                        <br />
                        <input type="text" v-model="user.password" />
                        <br />
                        <button type="button" style="display: block; margin: 5px auto;" @click="gettoken">Запрос</button>
                        <div class="servresp">
                            Ответ сервера: <span v-text="loginresponse"></span>                            
                        </div>
                    </div>
                    <div class="reqtoken">
                        <h4>Запрос погоды</h4>
                        <label>Токен</label>
                        <br />
                        <input type="text" v-model="user.token" />
                        <br />
                        <button type="button" style="display: block; margin: 5px auto;" @click="getweather">Запрос</button>
                        <div class="servresp">
                            Ответ сервера:<br /><span v-html="weather"></span>
                            <hr />
                            Ответ сервера - JSON:<br /><span v-text="weatherresponse"></span>                            
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        const app = new Vue({
          el: '#vueapp',
          data(){
            return{
              user: {
                login: null,
                password: null,
                token: null
              },
              loginresponse: "",
              weatherresponse: ""
            }
          },
          mounted(){
            
          },
          methods:{
            ajaxfun(url, method, body=null, token=null, callback){
                let headers = {};
                if(!!token){
                    headers["token"] = token;
                }
                headers["Content-type"] = "application/json; charset=UTF-8";
                fetch(url, {
                  method: method,
                  headers: headers,
                  body: (body !== null) ? JSON.stringify(body) : null
                }).then(response => {
                    return response.json();
                }).then(req => {
                    return callback(req);
                }).catch(e => {
                    console.log(e);
                });         
            },
            gettoken(){
                this.ajaxfun("/auth", "POST", this.user, null, (req) => {
                    this.loginresponse = req;
                })
            },
            getweather(){
                this.ajaxfun("/weather", "GET", null, this.user.token, (req) => {
                    this.weatherresponse = req;
                })
            },            
          },
          computed:{
            weather: function(){
                if(this.weatherresponse == ""){ return "";}
                if(!! this.weatherresponse.status){
                    return "Ошибка: " + this.weatherresponse.status;
                }
                return this.weatherresponse.reduce((acc, current)=>{
                    return acc += current.town + ": " + current.current_temp + '&deg;C<br />';
                }, '')
            }
          }
        });        
    </script>
</html>
