<template>
<div>
    <CCard>
        <CCardHeader>
            <strong>Ερωτηματολόγια τμημάτων</strong>
        </CCardHeader>
        <CCardBody>
            <CSelect
            size="lg"
            placeholder="Επιλογή τμήματος.."
            horizontal
            :options="tmhmata"
            :value.sync="id"
            >
            </CSelect>
        </CCardBody>
        <CCardFooter>
            <CButton @click="getErotimatologiaAnaTmhma()" color="primary" class="px-4">Αναζήτηση</CButton>
        </CCardFooter>
    </CCard>
    <div v-for="entry in erotimatologia" :key="entry.id">
        <div v-if="entry.active === 1">
        <CCard>
            <CCardHeader>
                <strong>Τίτλος ερωτηματολογίου:</strong>{{entry.title}}
                <br>
                <strong>Αριθμός ερωτήσεων:</strong>{{entry.NumOfQuest}}
                <br>
                <strong>Ημερομηνία λήξης:</strong>{{entry.expire}}
            </CCardHeader>
            <CCardFooter>
                <CButton @click=" myModal = true,getQnAForModip(entry.id)" color="primary" variant="" size="sm">Εμφάνιση ερωτήσεων</CButton>
            </CCardFooter>
        </CCard>
        </div>
        <div v-else-if="entry.active === 2">
            <CCard>
            <CCardHeader>
                <strong>Τίτλος ερωτηματολογίου:</strong>{{entry.title}}
                <br>
                <strong>Αριθμός ερωτήσεων:</strong>{{entry.NumOfQuest}}
                <br>
                <strong>Ημερομηνία λήξης:</strong>{{entry.expire}}
                <br>
                <br>
                <CAlert show color="danger">*Το ερωτηματολόγιο έχει λήξει ή έχει απενεργοποιηθεί από τον υπεύθυνο.</CAlert>
            </CCardHeader>
            <CCardFooter>
                <CButton @click=" myModal = true,getQnAForModip(entry.id)" color="primary" variant="" size="sm">Εμφάνιση ερωτήσεων</CButton>
            </CCardFooter>
        </CCard>
        </div>
        <div v-else>
            <CAlert show color="danger">*Δεν υπάρχουν ερωτηματολόγια.</CAlert>
        </div>



         <CModal
          :show.sync="myModal"
          :no-close-on-backdrop="true"
          :centered="true"
          size="lg"
          >
          <CForm @submit.prevent="">
            <div v-for="(quest,index) in questions" :key="index">
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
                            :inline="key % 2 === 1"
                          />
                        </div>
                        <div v-if="quest.type == 2">
                            <CTextarea
                              placeholder="Απάντηση"
                              horizontal
                              rows="3"
                            />
                        </div>
                  </CCardBody>
                </CCard>
            </div>
          </CForm>
          
          <template #header>
            <h4>Ερωτήσεις:</h4>
          </template>
          <template #footer>
            <CButton @click="myModal = false" color="dark">Έξοδος</CButton>
          </template>
        </CModal>

    </div>
</div>
    
</template>

<script>
import axios from 'axios';

export default {
    
    data() {

        return{
            tmhmata:[],
            erotimatologia:[],
            questions:[],
            id:'',

            myModal:false,
        }

    },

    methods:{
        getTmhmata() 
        {
            axios.post("http://localhost/restapi/api/modip/getTmhmata.php")
            .then(response => this.tmhmata = response.data)
            .catch(error => {
            this.erroMessage = error.message;
            console.error("There was an error!", error);
        })
        },

        getErotimatologiaAnaTmhma() {
            axios.post("http://localhost/restapi/api/modip/getErotimatologiaAnaTmhma.php",{tmhma_id:this.id})
            .then(response => this.erotimatologia = response.data)
            .catch(error => {
            this.erroMessage = error.message;
            console.error("There was an error!", error);
        })
        },

        getQnAForModip(id) {
        axios.post("http://localhost/restapi/api/modip/getQnAForModip.php",{id:id})
            .then(response => this.questions = response.data)
            .catch(error => {
            this.erroMessage = error.message;
            console.error("There was an error!", error);
        })
    },

    },

    

    mounted(){
        this.getTmhmata();
    }

}
</script>
