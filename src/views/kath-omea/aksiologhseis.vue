<template>
    <div>
        <CCard>
            <CCardHeader>
                <strong>Αναζήτηση αξιολογήσεων</strong>
            </CCardHeader>
            <CCardBody>
                <CSelect
                size="lg"
                placeholder="Επιλογή μαθήματος.."
                horizontal
                :options="classes"
                :value.sync="class_id"
                >
                </CSelect>
                <CSelect
                size="lg"
                placeholder="Επιλογή Ερωτηματολογίου.."
                horizontal
                :options="erotimatlogia"
                :value.sync="erot_id"
                >
                </CSelect>
            </CCardBody>
            <CCardFooter>
                <CButton @click="getQuestions()" color="primary" class="px-4" >Αναζήτηση</CButton>
            </CCardFooter>
        </CCard>

    
        <div v-for="entry in questions.records" :key="entry.id">
            <CCard>
                <CCardHeader>
                    <strong>{{entry.question}}</strong>
                </CCardHeader>
                <CCardBody>
                    <div v-if="entry.type == 1">
                         <CButton @click="chartModal = true,getApanthseisRadio(entry.id)" color="primary" class="px-4" >Εμφάνιση των απαντήσεων</CButton>
                    </div>
                    <div v-if="entry.type == 2">
                        <CButton @click="textModal = true, getApanthseisText(entry.id)" color="primary" class="px-4">Εμφάνιση των απαντήσεων</CButton>
                    </div>
                </CCardBody>
                <CModal
                    :show.sync="chartModal"
                    :no-close-on-backdrop="true"
                    :centered="true"
                    size="lg"
                    color="dark"
                    >
                        <CChartDoughnut
                        :datasets="defaultDatasets"
                        :labels="apanthseis_radio_answers.labels"
                    />
                    <template #header>
                        <h6 class="modal-title">Απαντήσεις</h6>
                        <CButtonClose @click="chartModal = false" class="text-white"/>
                    </template>
                    <template #footer>
                        <CButton @click="chartModal = false" color="dark">Κλείσιμο</CButton>
                    </template>
                </CModal>
                <CModal
                    :show.sync="textModal"
                    :no-close-on-backdrop="true"
                    :centered="true"
                    size="lg"
                    color="dark"
                    >
                    <div v-for="item in apanthseis_text.records" :key="item.ans">
                        <CCard>
                            <CCardHeader>
                                <p>Ο/Η φοιτητής/ρια απάντησε:</p>
                                <strong>{{item.ans}}</strong>
                            </CCardHeader>
                        </CCard>
                    </div>
                    <template #header>
                        <strong>Απαντήσεις</strong>
                    </template>
                    <template #footer>
                        <CButton @click="textModal = false" color="dark">Κλείσιμο</CButton>
                    </template>
                </CModal>
            </CCard>
        </div>


    </div>    

</template>




<script>
import axios from 'axios';
import { CChartDoughnut } from '@coreui/vue-chartjs'

export default  {
    name: 'CChartDoughnutExample',
    components: { CChartDoughnut },
    computed: {
        defaultDatasets () {
        return [
            {
            backgroundColor: [
                '#41B883',
                '#E46651',
                '#00D8FF',
                '#DD1B16',
                '#A9A9A9',
                '#9932CC',
                '#00008B',
                '#228B22',
                '#FFD700',
                '#A0522D'
            ],
            data: this.apanthseis_radio_answers.data
            }
        ]
        }
    },

    data() {
        return {

            classes:[],
            erotimatlogia:[], //pou yparxoun gia to tmhma
            questions:[],
            apanthseis_text:[],
            apanthseis_radio_answers:{},


            class_id:'',  //gia anazhthsh aksiologhsewn
            erot_id:'',  //gia anazhthsh aksiologhsewn

            //x:true,

            id:'', //prof_id gia getData
            tmhma_id:'',

            chartModal:false,
            textModal:false,
        }
    },

    methods: {

        getData() {
            axios.post("http://localhost/restapi/api/Omea/mathKathGiaSelect.php",{id:this.id})
                .then(response => this.classes=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
            })
      },

        getErot() {
            axios.post("http://localhost/restapi/api/Omea/getErotGiaSelect.php",{tmhma_id:this.tmhma_id})
                .then(response => this.erotimatlogia=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
        })
      },

        getQuestions() {
            axios.post("http://localhost/restapi/api/Omea/getQuestions.php",{erot_id:this.erot_id})
                .then(response => this.questions=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
            })
        },

        getApanthseisText(id) {
            axios.post("http://localhost/restapi/api/Omea/getApanthseisText.php",{quest_id:id,class_id:this.class_id})
                .then(response => this.apanthseis_text=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
            })
        },


        getApanthseisRadio(id) {
            axios.post("http://localhost/restapi/api/Omea/getApanthseisRadio.php",{quest_id:id,class_id:this.class_id})
                .then(response => this.apanthseis_radio_answers=response.data)
                .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
            })
        },



    },

    mounted() {

        if(localStorage.prof_id) {
        this.id=localStorage.prof_id;
        }
        if(localStorage.tmhma_id) {
        this.tmhma_id=localStorage.tmhma_id;
        }

        this.getData();
        this.getErot();
    }

}
</script>
