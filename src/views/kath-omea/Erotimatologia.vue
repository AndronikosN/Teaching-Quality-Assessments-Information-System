<template>
  <div> 
      <h1>{{t_type}}</h1>
      <CRow v-for="entry in erotim.records" :key="entry.quiz_id">
      <CCol md="12">
          
        <CCard >
          <CCardHeader >
            <strong>{{entry.title}}</strong> 
            <CButton type="submit" size="sm" ><CIcon name="cil-pencil"/> Edit</CButton>
          </CCardHeader>
       
          <CCardBody>
            {{entry.class_name}}
          </CCardBody>
        
          <CCardFooter>
                <CButton type="submit" size="sm" color="primary" @click="redirectToAddQuestion()"><CIcon name="cil-pencil"/> ADD QUESTION</CButton> |
                <CButton type="reset" size="sm" color="danger" @click="deleteListing(entry.quiz_id)"><CIcon name="cil-ban"/> DELETE</CButton>
          </CCardFooter>
        </CCard>

      </CCol>
     </CRow>

    <CRow>
    <CCol col="12" md="6">
      <CCard>
        <CCardBody>        
          <CButton @click="collapse = !collapse" color="info" class="mb-2">
            Προσθήκη ερωτηματολογίου
          </CButton>
          <CCollapse :show="collapse" :duration="400">
            <CCard body-wrapper>
              <CForm @submit.prevent="postData">
                
                  <h1>Προσθήκη ερωτηματολογίου</h1>
                  <CInput
                    placeholder="Τίτλος ερωτηματολογίου"
                    v-model="title"
                    invalid-feedback="Δώστε τίτλο"
                  >
                  </CInput>
                  
                  <CInput
                    placeholder="Μάθημα"
                    v-model="class_name"
                    invalid-feedback="Δώστε τίτλο μαθήματος"
                  >
                    
                  </CInput>
                  <CRow>
                    <CCol col="6" class="text-left">
                      <CButton color="success" class="px-4" type="submit">Προσθήκη</CButton>
                    </CCol>
                   
                  </CRow>
                </CForm>
            </CCard>
          </CCollapse>  
       </CCardBody>
      </CCard>
    </CCol>
    </CRow>

  </div>
</template>

<script>

import axios from 'axios';

export default {
    
    name: 'Erot',

    data() {
        return {
            collapse: false,

            erotim:[],
            errorMessage:null,
            
            title:'',
            class_name:'',

            t_type:''

        }
    },

    methods: {
    //triggers when click on Edit 
    redirectToAddQuestion() 
    {
      this.$router.push('/add-question');
    },

    getData() 
    {
      axios.get("http://localhost/restapi/api/read.php")
           .then(response => this.erotim=response.data)
           .catch(error => {
           this.errorMessage = error.message;
           console.error("There was an error!", error);
      })
    },

    //triggers when click on Delete
    deleteListing(id) 
    {
      axios.post("http://localhost/restapi/api/delete.php?quiz_id=" + id)
           .then((response) => {this.getData();
           })
    },

    postData()
    {
      axios.post("http://localhost/restapi/api/create.php",{title:this.title,class_name:this.class_name})
            .then((response) => {this.getData()}) 
            .catch((error) => console.log(error))
    }

 },

    mounted()
    {
      this.getData();

      if(localStorage.type){
        this.t_type = localStorage.type;
      }

    } 
  };

</script>