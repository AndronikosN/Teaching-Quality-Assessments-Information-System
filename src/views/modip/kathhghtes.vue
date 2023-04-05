<template>
    <div>
        <CCard>
            <CCardHeader>
                <strong>Καθηγητές ιδρύματος</strong>
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
                <CButton @click="getKathhghtesAnaTmhma()" color="primary" class="px-4">Αναζήτηση</CButton>
            </CCardFooter>
        </CCard>

        <div v-for="entry in kathhghtes.records" :key="entry.id">
            <CCard>
                <CCardHeader>
                    <strong>Όνομα:</strong>{{entry.name}}
                    <br>
                    <strong>Επώνυμο:</strong>{{entry.lastname}}
                    <br>
                    <strong>Username:</strong>{{entry.username}}
                </CCardHeader>
            </CCard>
        </div>
    </div>

</template>



<script>
import axios from 'axios';

export default {
    
    data() {

        return{
            tmhmata:[],
            kathhghtes:[],

            id:'', //gia anazhthsh kathhghtwn
        }
    },

    methods: {
        getTmhmata() 
        {
            axios.post("http://localhost/restapi/api/modip/getTmhmata.php")
            .then(response => this.tmhmata = response.data)
            .catch(error => {
            this.erroMessage = error.message;
            console.error("There was an error!", error);
        })
        },

        getKathhghtesAnaTmhma()
        {
            axios.post("http://localhost/restapi/api/modip/getKathhghtesAnaTmhma.php",{id:this.id})
            .then(response => this.kathhghtes = response.data)
            .catch(error => {
                this.errorMessage = error.message;
                console.error("There was an error!", error);
            })
        }
    },

    mounted() {
        this.getTmhmata();
    }

}
</script>
