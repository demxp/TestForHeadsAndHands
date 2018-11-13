<template>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Добавляем город</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Выберите город</label>
                <select2 :options="towns" v-model="town.town_id" style="width: 100%;"></select2>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a class="btn btn-default" @click="$parent.$emit('switch-mode', {'mode': 'indextowns', 'id': null})">Назад</a>
          <button class="btn btn-success pull-right" @click="addtown">Добавить</button>
        </div>
      </div>
</template>

<script>
    export default {
      data(){
        return{
          towns: [],
          town: {
            town_id: null,
            name: null
          }
        }
      },
      mounted(){
        this.ajaxfun('/data/townlist.json', 'get', null, this.fillTowns);
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
        fillTowns(data){
          this.towns.push({
            titleimage: 0,
            text: "Выберите город",
            id: 0
          });      
          data.map((item, i) => {
            this.towns.push({
              text: item.name,
              id: item.town_id
            });
          });
        },
        addtown(){
          if(this.town.town_id === null){
            alert("Надо выбрать город!");
            return false;
          }      
          let url = '/api/v1/towns';
          this.ajaxfun(url, 'post', {
            town_id: this.town.town_id,
            name: this.selectedTownName
          }, (req) => {
            if(req.status == 'ok'){
              this.$parent.$emit('switch-mode', {'mode': 'indextowns', 'id': null});
              return true;
            }
            customAlert(req);
          });       
        }
      },
      computed: {
        selectedTownName: function () {
          let cur_town = this.towns.filter((el)=>{
            return this.town.town_id == el.id;
          })
          return cur_town[0].text;
        }
      }
    }
</script>