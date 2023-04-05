<template>
    <div>
        <CCard>
            <CCardHeader>
                <h1><strong>Δημιουργία ερωτηματολογίου</strong></h1>
            </CCardHeader>
            <CCardBody>
                <CForm @submit.prevent="postData">
                  <CSelect
                    label="Επιλογή τμήματος:"
                    size="lg"
                    placeholder="Επιλογή.."
                    horizontal
                    :options="classes"
                    :value.sync="tmhma_id"
                  >
                  </CSelect>

                  <CInput
                    label="Τίτλος:"
                    size="lg"
                    placeholder="Τίτλος ερωτηματολογίου"
                    v-model="title"
                    invalid-feedback="Δώστε τίτλο.."
                    horizontal
                  >
                  </CInput>

                  <CInput label="Επιλογή Ημερομηνίας Λήξης:" 
                    type="date"
                    v-model="expire" 
                    size="lg"
                    horizontal
                    />
                  
                  <CCol col="6" class="text-left">
                    <CButton @click="redirectToErot()" color="success" class="px-4" type="submit">Εισαγωγή ερωτηματολογίου</CButton>
                  </CCol>
                </CForm>
            </CCardBody>

        </CCard>

        <CAlert show color="danger">*Μετά την Εισαγωγή ερωτηματολογίου, θα μεταφερθείτε στα Ερωτηματολόγια για επεξεργασία και δημιουργία ερωτήσεων!</CAlert>

        
    </div>
</template>

<script>
import axios from 'axios';

export default {

    data() {
        return{
            id:'',
            classes:[],
            tmhma_id:'',
            title:'',
            expire:'',


           

            selectOptions: [
                {
                    value:'1',
                    label:"Πολλαπλής επιλογής"
                },
                {
                    value:'2',
                    label:"Κείμενο"
                }
            ],
            selectOption:''

        }    
    },

    methods: {

       getData()
        {
        axios.post("http://localhost/restapi/api/Omea/findTmhma.php",{id:this.id})
            .then(response => this.classes=response.data)
            .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
        })
        },

        postData()
        {
            axios.post("http://localhost/restapi/api/Omea/eisagwghErot.php",{title:this.title,tmhma_id:this.tmhma_id,expire:this.expire,prof_id:this.id})
            .then((response) => {this.getData()}) 
            .catch((error) => console.log(error))
        },

        redirectToErot() 
        {
            this.$router.push('/kath-omea/erotOmea');
        },

    },

    mounted() {
        if(localStorage.prof_id){
            this.id = localStorage.prof_id;
        }

        this.getData();


    }
}


</script>
