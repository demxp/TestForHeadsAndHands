<template>
  <div class="box">
    <div class="box-body">
      <div class="form-group">
        <a v-if="towns.length < 20" class="btn btn-success" @click="$parent.$emit('switch-mode', {'mode': 'addtown', 'id': null})">Добавить</a>
        <p v-if="towns.length >= 20">Задано максимальное число городов (ограничение 20 городов)</p>
      </div>      
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Город</th>
            <th>Температура</th>            
            <th>Действия</th>
          </tr>
        </thead>
        <tbody v-if="towns.length == 0">
          <tr>
            <td colspan=5><center><h3>НЕТ ДАННЫХ</h3></center></td>
          </tr>
        </tbody>
        <tbody>
          <tr v-for="town in towns">
            <td>{{ town.town_id }}</td>
            <td><span v-text="town.name"></span></td>
            <td><span v-text="town.current_temp"></span></td>            
            <td>
              <button class="btn btn-xs btn-danger btn-block" @click="deleteTown(town)">Удалить</button>
            </td>   
          </tr>                 
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
    export default {
      data(){
        return{
          towns: []
        }
      },
      mounted(){
        this.ajaxfun('/api/v1/towns', 'get', null, this.fillTable)
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
        fillTable(data){
          data.map((item, i) => {
            item.success = false;
            item.danger = false;
            if(!!this.towns[i]){
              Object.keys(item).map((param) => this.towns[i][param] = item[param]);
            }else{
              this.towns.push(item)
            }
          });
          if(data.length < this.towns.length){
            this.towns.splice(data.length,this.towns.length - data.length);
          }
        },
        deleteTown(town){
          if(!confirm("Вы уверены?")){return false;}
          let url = '/api/v1/towns/'+town.town_id;
          this.ajaxfun(url, 'delete', {
            id: town.town_id
          }, () => {this.ajaxfun('/api/v1/towns', 'get', null, this.fillTable)});         
        },
        createCallback(obj){
          return function(req){
            if(req.status == 'ok'){
              obj.success = true;
              setTimeout(() => {obj.success = false;},1000);
            }else{
              obj.danger = true;
              setTimeout(() => {obj.danger = false;},1000);            
            }
          };        
        }
      }  
    }
</script>