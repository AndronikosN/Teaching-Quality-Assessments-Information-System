<template>
    <div>
        <h1><strong>Τα μαθήματα μου:</strong></h1>
        <CCard v-for="entry in classes.records" :key="entry.id">
            <CCardHeader>
                <strong>{{entry.title}}</strong>({{entry.eclass_code}})
            </CCardHeader>
            <CCardFooter>
                <h6>Tμήμα:{{entry.name}}</h6>
            </CCardFooter>
        </CCard>        


    </div>

</template>

<script>
import axios from 'axios';

export default{

    name: 'mathimataKath',

    data(){
        return {

            classes: [],
            id: ''

        }
    },

    methods: {

        getData()
      {
        axios.post("http://localhost/restapi/api/Omea/mathKath.php",{id:this.id})
            .then(response => this.classes=response.data)
            .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
        })
      }

    },

    mounted(){

    if(localStorage.prof_id) {
      this.id=localStorage.prof_id;
    }
    
    this.getData();
  }


}

</script>
