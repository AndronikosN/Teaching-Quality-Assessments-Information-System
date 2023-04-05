<template>
    <div>
        <h1><strong>-Πρόχειρα</strong>(Ιnactive)</h1>
            <CCard v-for="entry in inactive.records" :key="entry.id">
                <CCardHeader>
                    <CRow><strong>Τίτλος:  </strong>{{entry.title}}</CRow>
                    <CRow><strong>Αριθμός ερωτήσεων:</strong>{{entry.NumOfQuest}}</CRow>
                </CCardHeader>

                <CCardBody>
                    <CCol col="6" class="text-left">
                        <CButton color="secondary" @click="modal_id=entry.id,successModal = true" class="px-4" >Αποστολή Ερωτηματολογίου(Active)</CButton>
                    </CCol>
                </CCardBody>

                <CCardFooter>
                    <CCol col="6" class="text-left">
                        <CButton @click="modal_id=entry.id, largeModal = true" color="primary" class="px-4" >Επεξεργασία</CButton>
                        <CButton type="reset" color="danger" @click="modal_id=entry.id, dangerModal=true" class="mr-1">Διαγραφή</CButton>
                        <!--lush me collapse 
                        <CButton type="reset" color="danger" @click="collapse=!collapse" class="mr-1">Διαγραφή</CButton>
                        <CCollapse :show="collapse" :duration="400">
                            <CAlert show color="danger">Εάν διαγράψετε το ερωτηματολόγιο, θα διαγραφούν μαζί και οι ερωτήσεις του.
                             Θέλετε να συνεχίσετε;</CAlert>
                            <CButton @click="collapse =!collapse" color="dark">Ακύρωση</CButton>
                            <CButton type="reset" color="success" @click="deleteErot(entry.id)">Τελική διαγραφή όλων</CButton>
                        </CCollapse>
                        -->
                    </CCol>
                </CCardFooter>


                <CModal
                    :show.sync="largeModal"
                    :no-close-on-backdrop="true"
                    :centered="true"
                    size="lg"
                    >
                    <template #header>
                        <h3 class="modal-title">Επεξεργασία ερωτηματολογίου</h3>
                        <CButtonClose @click="largeModal = false" class="text-white"/>
                    </template>
                    <CForm @submit.prevent="changeTitle(modal_id)">
                        <CInput label="Αλλαγή τίτλου:"
                            size="lg"
                            placeholder="Αλλαγή τίτλου.."
                            v-model="title"
                            invalid-feedback="Δώστε τίτλο.."
                            horizontal
                        >
                        </CInput>
                        <CCol col="6" class="text-left">
                            <CButton icon="cil-pencil" color="primary" class="px-4" type="submit">Αλλαγή</CButton>
                        </CCol>
                    </CForm>
                    <CForm @submit.prevent="changeDate(modal_id)">
                        <CInput label="Αλλαγή ημερομηνίας λήξης:" 
                        type="date"
                        v-model="expire" 
                        size="lg"
                        horizontal
                        />
                        <CCol col="6" class="text-left">
                            <CButton icon="cil-pencil" color="primary" class="px-4" type="submit">Αλλαγή</CButton>
                        </CCol>
                    </CForm>

                    <CDropdownDivider>
                    </CDropdownDivider>

                    <CRow>
                        <CCol col="6" class="text-left">
                            <CButton @click="getQuestions(modal_id)"  variant="ghost" color="dark" class="px-2" >Εμφάνιση ερωτήσεων</CButton>               
                        </CCol>
                    </CRow>
                    <CListGroup v-for="item in questions.records" :key="item.id">
                        <CListGroupItem>
                            <strong>{{item.question}}</strong>
                            <CButton type="reset" variant="ghost" color="danger" @click="deleteQuestion(item.id,modal_id)" class="mr-1">Διαγραφή</CButton>
                            <div v-if="item.type === 1"> 
                                Τύπος απάντησης: Πολλαπλής Επιλογής
                            </div>
                            <div v-if="item.type === 2"> 
                                Τύπος απάντησης: Κείμενο
                            </div>
                        </CListGroupItem>
                    </CListGroup>

                    <CRow>
                        <CCol col="12" md="10">
                            <CCard>
                                <CCardBody>        
                                    <CButton @click="collapse = !collapse" color="info" class="mb-2">Προσθήκη ερώτησης</CButton>
                                    <CCollapse :show="collapse" :duration="400">
                                       
                                            <CForm ref="form" @submit.prevent="postQnA(modal_id)">
                                                <CInput
                                                ref="input"
                                                label="Eρώτηση"
                                                placeholder="Ερώτηση"
                                                v-model="question_title"
                                                invalid-feedback="Δώστε τίτλο"
                                                horizontal
                                                >
                                                </CInput>
                                        
                                                <CSelect
                                                label="Τύπος απάντησης:"
                                                placeholder="Παρακαλώ επιλέξτε"
                                                horizontal
                                                :options="selectOptions"
                                                :value.sync="selectOption"
                                                >
                                                </CSelect>

                          
                                                <div v-if="selectOption === 1">
                                                    <span class="scale">Επιλογή Αριθμού Απαντήσεων
                                                        <CSelect
                                                        placeholder="Επιλογή.." 
                                                        type="number"
                                                        :options="numberOfAnswers"
                                                        :value.sync="number"
                                                        v-on:change="cNum(number)"
                                                        >
                                                        </CSelect> 
                                                    </span>

                                                    <div v-for="(n,index) in radioAnswers" :key="index">
                                                        <CInput
                                                        label="Απάντηση :"
                                                        v-model="radioAnswers[index]" 
                                                        name="radioAnswers"
                                                        size="sm"
                                                        horizontal
                                                        placeholder="Προσθήκη Απάντησης..."
                                                        />
                                                    </div>
                                                </div>
                            
                                                <CRow>
                                                    <CCol col="6" class="text-left">
                                                        <CButton color="primary" @click="collapse = !collapse,resetForm()" class="px-4" type="submit">Προσθήκη νέας ερώτησης</CButton>
                                                    </CCol>
                                                </CRow>
                                            </CForm>
                                        
                                    </CCollapse>  
                                </CCardBody>
                            </CCard>
                        </CCol>
                    </CRow>
                    <template #footer>
                        <CButton type="reset" color="success" @click="largeModal = false, collapse = false">Τέλος επεξεργασίας</CButton>
                    </template>
                </CModal>

                <CModal
                    :show.sync="successModal"
                    :no-close-on-backdrop="true"
                    :centered="true"
                    size="lg"
                    color="dark"
                    >
                    Εάν συνεχίσετε το ερωτηματολόγιο θα σταλεί στους φοιτητές για να απαντηθεί.
                    Δεν θα υπαρχει δυνατότητα επεξεργασίας.
                    Θέλετε να συνεχίσετε;
                    <template #header>
                        <h6 class="modal-title">Προσοχή!</h6>
                        <CButtonClose @click="successModal = false" class="text-white"/>
                    </template>
                    <template #footer>
                        <CButton @click="successModal = false" color="dark">Ακύρωση</CButton>
                        <CButton type="reset" color="success" @click="makeActiveErot(modal_id)">Αποστολή</CButton>
                    </template>
                </CModal>

                <CModal
                    :show.sync="dangerModal"
                    :no-close-on-backdrop="true"
                    :centered="true"
                    size="lg"
                    color="danger"
                    >
                    Εάν διαγράψετε το ερωτηματολόγιο, θα διαγραφούν μαζί και οι ερωτήσεις του.
                    Θέλετε να συνεχίσετε;
                    <template #header>
                        <h6 class="modal-title">Προσοχή!</h6>
                        <CButtonClose @click="dangerModal = false" class="text-white"/>
                    </template>
                    <template #footer>
                        <CButton @click="dangerModal = false" color="dark">Ακύρωση</CButton>
                        <CButton type="reset" color="success" @click="deleteErot(modal_id)">Τελική διαγραφή όλων</CButton>
                    </template>
                </CModal>
            </CCard>

            <h1><strong>-Ενεργά</strong>(Active)</h1>
            <CCard v-for="entry in active.records" :key="entry.id">
                <CCardHeader  color="success" >
                    <CRow><strong>Τίτλος:{{entry.title}}</strong></CRow>
                    <CRow><strong>Αριθμός ερωτήσεων:{{entry.NumOfQuest}}</strong></CRow>
                </CCardHeader>
                <CCardBody>
                    Λήγει: {{entry.expire}}
                </CCardBody>
                <CCardFooter>
                    <CButton @click="makeInactiveErot(entry.id)" color="danger" variant="ghost" size="lg">Απενεργοποίηση</CButton>
                </CCardFooter>
            </CCard>

            <h1><strong>-Απενεργοποιημένα</strong>(Disabled)</h1>
            <CCard v-for="entry in disabled.records" :key="entry.id">
                <CCardHeader  color="secondary" >
                    <CRow><strong>Τίτλος:{{entry.title}}</strong></CRow>
                    <CRow><strong>Αριθμός ερωτήσεων:{{entry.NumOfQuest}}</strong></CRow>
                </CCardHeader>
                <CCardBody>
                    Λήγει: {{entry.expire}}
                </CCardBody>
                <CCardFooter>       
                    <CButton  @click=" modal_id=entry.id ,  activeModal = true" color="success" variant="ghost" size="lg">Ενεργοποίηση</CButton>
                    <CButton type="reset" color="danger" @click="modal_id=entry.id, deleteModal = true" variant="ghost" size="lg">Διαγραφή</CButton>
                </CCardFooter>

                <CModal
                    :show.sync="activeModal"
                    :no-close-on-backdrop="true"
                    :centered="true"
                    size="lg"
                    >
                    <CForm @submit.prevent="changeDate(modal_id)">
                        <CInput label="Αλλαγή ημερομηνίας λήξης:" 
                        type="date"
                        v-model="expire" 
                        size="lg"
                        horizontal
                        />
                        <CCol col="6" class="text-left">
                            <CButton icon="cil-pencil" color="primary" class="px-4" type="submit">Αλλαγή</CButton>
                        </CCol>
                    </CForm>
                    <template #header>
                        <h6 class="modal-title">Συμπληρώστε μια αποδεκτή ημερομηνία, αν χρειάζεται.</h6>
                        <!--
                        <CButtonClose @click="activeModal = false" class="text-white"/>
                        -->
                    </template>
                    <template #footer>
                        <CButton @click="activeModal = false" color="dark">Ακύρωση</CButton>
                        <CButton type="reset" color="success" @click="makeActiveErot(modal_id), activeModal = false">Ενεργοποίηση</CButton>
                    </template>
                </CModal>

                <CModal
                    :show.sync="deleteModal"
                    :no-close-on-backdrop="true"
                    :centered="true"
                    size="lg"
                    color="danger"
                    >
                    Εάν διαγράψετε το ερωτηματολόγιο, θα διαγραφούν μαζί οι ερωτήσεις του ΚΑΙ ΟΙ ΠΙΘΑΝΈΣ ΑΠΑΝΤΉΣΕΙΣ ΤΩΝ ΦΟΙΤΗΤΏΝ.
                    Θέλετε να συνεχίσετε;
                    <template #header>
                        <h6 class="modal-title">Προσοχή!</h6>
                        <CButtonClose @click="deleteModal = false" class="text-white"/>
                    </template>
                    <template #footer>
                        <CButton @click="deleteModal = false" color="dark">Ακύρωση</CButton>
                        <CButton type="reset" color="success" @click="deleteErot(modal_id)">Τελική διαγραφή όλων</CButton>
                    </template>
                </CModal>
            </CCard>
        
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return{
            //Api stuff
            tmhma_id:'',
            inactive:[],
            active:[],
            disabled:[],
            questions:[],
            title:'', //erot
            expire:'', //dateErot

            modal_id:'', //gia v-bind sta modal

            //Effect stuff
            collapse:false,

            //for question
            question_title:'',

            //option for answers
            selectOptions: [
                {
                    value:1,
                    label:'Πολλαπλής Επιλογής'
                },
                {
                    value:2,
                    label:'Κείμενο'
                }
            ],
            selectOption:'',
            radioAnswers:[],
            number:'',
            //numbers:[],

            numberOfAnswers:[{value:2},{value:3},{value:4},{value:5},{value:6},{value:7},{value:8},{value:9},{value:10}],

            //Modals
            largeModal:false,
            dangerModal: false,
            successModal:false,
            deleteModal:false,
            activeModal:false,
        }
    }, 

    methods: {

        resetForm(){
            this.$refs.form.reset();
        },
    //GetData
        getDataInactive() {
            axios.post("http://localhost/restapi/api/Omea/inactiveErot.php",{tmhma_id:this.tmhma_id})
                .then(response => this.inactive=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })
        },

        getDataActive() {
            this.getDataInactive();
            this.getDataDisabled();
            axios.post("http://localhost/restapi/api/Omea/activeErot.php",{tmhma_id:this.tmhma_id})
                .then(response => this.active=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })
        },

        getDataDisabled() {
            axios.post("http://localhost/restapi/api/Omea/disabledErot.php",{tmhma_id:this.tmhma_id})
                .then(response => this.disabled=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })
        },

        getQuestions(id) {
            this.getDataInactive();
            axios.post("http://localhost/restapi/api/Omea/getQuestions.php",{erot_id:id})
                .then(response => this.questions=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })
        },


 
    //ChangeData
        makeActiveErot(id) {
            this.successModal=false;
            axios.post("http://localhost/restapi/api/Omea/makeActiveErot.php",{id:id})
                .then(response => this.getDataActive())
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })
        },


        makeInactiveErot(id) {
            axios.post("http://localhost/restapi/api/Omea/makeInactiveErot.php",{id:id})
                .then(response => this.getDataActive())
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })
        },

        deleteErot(id) {
        this.dangerModal=false;
        this.deleteModal=false;
        axios.post("http://localhost/restapi/api/Omea/deleteErot.php",{id:id})
           .then((response) => {this.getDataActive();
           })
        },

        deleteQuestion(id,erot_id) {
            axios.post("http://localhost/restapi/api/Omea/deleteQuestion.php",{id:id})
           .then((response) => {this.getQuestions(erot_id);
           })
        },

        changeTitle(id) {
            this.largeModal=false;
            axios.post("http://localhost/restapi/api/Omea/updateNameErot.php",{id:id,title:this.title})
                .then(response => this.getDataActive())
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })

        },

        changeDate(id) {
            this.largeModal=false;
            axios.post("http://localhost/restapi/api/Omea/updateDate.php",{id:id,expire:this.expire})
                .then(response => this.getDataActive())
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
          })

        },

    //InsertData
        postQnA(erot_id)
        {
            axios.post("http://localhost/restapi/api/Omea/eisagwghQnA.php",{erot_id:erot_id ,question:this.question_title, type:this.selectOption, ans:this.radioAnswers})
            .then((response) => {this.getQuestions(erot_id)}) 
            .catch((error) => console.log(error))
        },


    //Helpers
        cNum(num) {  //Changes the length depenting on the number of answers 
            //this.numbers.length = num;
            this.radioAnswers.length = num;
        },


    },

    


    mounted() {
        if(localStorage.tmhma_id){
            this.tmhma_id = localStorage.tmhma_id;
        }


        this.getDataActive();
        //this.getDataInactive();
        //this.getDataDisabled();
    }
}
</script>
