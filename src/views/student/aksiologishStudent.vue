<template>
<div>
<CCard> 
  <CCardHeader> 
      <strong>Επιλογή ακαδημαϊκού έτους:</strong> 
  </CCardHeader>
  <CCardBody>
    <CSelect
      size="lg"
      horizontal
      placeholder="Επιλογή ακαδημαϊκού έτους.."
      :options="years"
      :value.sync="year"
      @change="getData()"
      />
  </CCardBody>
</CCard>


<CCard v-for="entry in classes.records" :key="entry.id_class">
  <div v-if="year=='2021-22'">
    <CCardHeader>
      Μάθημα: <strong>{{entry.title}}</strong>({{entry.eclass_code}})
    </CCardHeader>
    <CCardFooter>
      <CAlert show color="danger">Δεν υπάρχει ερωτηματολόγιο</CAlert>
    </CCardFooter>
  </div>
  
  <div v-if="year=='2022-23'">
    <CCardHeader>
      Μάθημα: <strong>{{entry.title}}</strong>({{entry.eclass_code}})
    </CCardHeader>

    <CCardFooter>

      <div v-for="(item,index) in active.records" :key="index">
          
          {{item.title}}
          
          <CButton @click=" myModal = true,getQnA(item.id,entry.id_class)" color="primary" variant="" size="sm">Απάντηση ερωτηματολογίου</CButton>
          
      

        <CModal
          :show.sync="myModal"
          :no-close-on-backdrop="true"
          :centered="true"
          size="lg"
          >

          <CForm @submit.prevent="">
            <div v-for="(quest,index) in questions" :key="index">
              <div v-if="quest.exist == 0">
                <CCard>
                  <CCardHeader color="light">
                    <h6>Ερώτηση {{index+1}}</h6>
                  </CCardHeader>
                  <CCardBody>
                      <h5>-{{quest.question}}</h5>
                        <div v-if="quest.type == 1">
                          <CInputRadioGroup
                            class="col-sm-9"
                            :options="quest.ans"
                            :checked.sync="ans[index]"
                            :inline="key % 2 === 1"
                          />
                        </div>
                        <div v-if="quest.type == 2">
                            <CTextarea
                              placeholder="Απάντηση"
                              v-model="ans[index]"
                              horizontal
                              rows="3"
                            />
                        </div>
                  </CCardBody>
                </CCard>
                <CButton v-if="index === questions.length - 1" @click="myModal = false, postAnswers()" type="submit" color="success" >Αποστολή απαντήσεων</CButton>
              </div>
              <div v-if="quest.exist == 1">
                <strong v-if="index === questions.length - 1">Το ερωτηματολόγιο για το συγκεκριμένο μάθημα έχει απαντηθεί!</strong>
              </div>
            </div>
          </CForm>
          

          

          <template #header>
            <h4>Αξιολόγηση Μαθήματος</h4>
          </template>
          <template #footer>
            <CButton @click="myModal = false" color="dark">Ακύρωση</CButton>
          </template>
        </CModal>

      </div>
    </CCardFooter>
  </div>
</CCard>

  
</div>
</template>

<script>

import axios from 'axios';


export default {
  
  name: 'aksiologishStudent',
  
  data() {
        return {

             years: ['2021-22', '2022-23'],

             classes: [],  //mathimata
             active:[],   //energa erot
             questions:[], //erwthseis
             ans:[],
             questions_id:[],

             apanthmenaErot: '', //true of false

             erot_id:'', //to solve the issue of the same erot_id on the apantiseis table
             id_class:'',



             am: '',
             year:'',
             tmhma_id:'',


             myModal:false,

             collpse:false,
      }
    },

    methods: {
        
      getData()
      {
        axios.post("http://localhost/restapi/api/Foithths/stuRead.php",{am:this.am,year:this.year})
            .then(response => this.classes=response.data)
            .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
        })
      },

       getDataActive() {
            axios.post("http://localhost/restapi/api/Omea/activeErot.php",{tmhma_id:this.tmhma_id})
                .then(response => this.active=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })
        },

        getQnA(id,id_class) {
            this.getQuestionsIds(id);
            this.erot_id = id;
            this.id_class = id_class;
            axios.post("http://localhost/restapi/api/Foithths/getQnA.php",{erot_id:id,mathhma_id:id_class,am_id:this.am,year:this.year})
                .then(response => this.questions=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
                })
        },

        //gia na dwsoume ta ids twn erwthsewn sto postAnswers
        getQuestionsIds(erot_id) {
          axios.post("http://localhost/restapi/api/Foithths/getQuestionsIds.php",{erot_id:erot_id})
                .then(response => this.questions_id=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })
        },

        postAnswers() {
            axios.post("http://localhost/restapi/api/Foithths/eisagwghApanthseis.php",{erot_id:this.erot_id, quest_id:this.questions_id, ans:this.ans, mathhma_id:this.id_class, am_id:this.am, year:this.year})
            .then((response) => {}) 
            .catch((error) => console.log(error))
        },


        

    },

  
  mounted(){

    if(localStorage.student_am) {
      this.am=localStorage.student_am;
    }
    
    if(localStorage.tmhma_id) {
      this.tmhma_id=localStorage.tmhma_id;
    }

    this.getDataActive();

  }
}

</script>
