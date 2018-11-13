<template>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title" v-text="mode.box_title"></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Логин</label>
                <input type="text" class="form-control" v-model="user.login">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Пароль</label>
                <input type="password" class="form-control" v-model="user.password">
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a class="btn btn-default" @click="$parent.$emit('switch-mode', {'mode': 'indexusers', 'id': null})">Назад</a>
          <button class="btn pull-right" :class="{'btn-success':mode.submit_style_success, 'btn-warning':mode.submit_style_warning}" @click="edituser" v-text="mode.submit_text"></button>
        </div>
      </div>
</template>

<script>
    export default {
      props: {
        userId: {
          type: Number,
          required: false,      
          default: null
        }
      },
      data(){
        return{
          user: {
            id: null,
            login: null,
            password: null
          },
          mode:{
            box_title: "Добавляем пользователя",
            submit_text: "Добавить",
            submit_style_success: true,
            submit_style_warning: false
          }
        }
      },
      mounted(){
        if(this.userId !== null){
          this.mode = {
            box_title: "Изменяем пользователя",
            submit_text: "Изменить",
            submit_style_success: false,
            submit_style_warning: true
          };
          let url = '/api/v1/users/' + this.userId;
          this.ajaxfun(url, 'get', null, (req) => {
            for(let i in req){
              this.user[i] = req[i];
            }
          });       
        }
      },
      methods:{
        ajaxfun(url, method, body=null, callback){
          fetch(url, {
            method: method,
            headers: {  
                  "Content-type": "application/json; charset=UTF-8",
                  'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            body: (body !== null) ? JSON.stringify(body) : null
          }).then(response => {
              return response.json();
          }).then(req => {
              return callback(req);
          }).catch(e => {
              console.log(e);
          });         
        },
        edituser(){
          if(this.user.login === null || this.user.login.length < 3){
            customAlert("Надо написать логин пользователя!");
            return false;
          }      
          if((this.user.id === null) && (this.user.password === null || this.user.password.length < 3)){
            customAlert("Надо написать пароль пользователя!");
            return false;
          }

          let url = '/api/v1/users';
          let method = 'post';
          let request_data = {
            login: this.user.login,
            password: this.user.password
          };

          if(this.user.id !== null){
            url += '/' + this.user.id;
            method = 'put';
            request_data.id = this.user.id;
          }
          
          this.ajaxfun(url, method, request_data, (req) => {
            if(req.status == 'ok'){
              this.$parent.$emit('switch-mode', {'mode': 'indexusers', 'id': null});
              return true;
            }
            customAlert(req);
          });       
        }
      }    
    }
</script>