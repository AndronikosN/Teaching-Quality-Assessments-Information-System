<template>
    <div>
        
        <CCard>
            <CCardHeader>
                <strong>Μαθήματα ιδρύματος ανά τμήμα</strong>
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
                <CButton @click="getMathhmataAnaTmhma(), collapse1 = !collapse1" color="primary" class="px-4">Αναζήτηση</CButton>
            </CCardFooter>
        </CCard>
        <CCollapse :show="collapse1" :duration="400">
            <CButton @click="emptyAnaTmhma()" variant="ghost" color="dark" class="px-2">Απόκρυψη</CButton>
        </CCollapse>
        <div v-for="entry in mathhmataAnaTmhma.records" :key="entry.id">
            <CCard>
                <CCardHeader>
                    <strong>Τίτλος μαθήματος:</strong>{{entry.title}}
                    <br>
                    <strong>Κωδικός e-class:</strong>{{entry.eclass_code}}
                </CCardHeader>
            </CCard>
        </div>
        <CCard>
            <CCardHeader>
                <strong>Μαθήματα ιδρύματος ανά καθηγητή</strong>
            </CCardHeader>
            <CCardBody>
                <CSelect
                size="lg"
                placeholder="Επιλογή καθηγητή.."
                horizontal
                :options="kathhghtes"
                :value.sync="id"
                >
                </CSelect>
            </CCardBody>
            <CCardFooter>
                <CButton @click="getMathhmataAnaKathhghth(), collapse=!collapse" color="primary" class="px-4">Αναζήτηση</CButton>
            </CCardFooter>
        </CCard>
        <CCollapse :show="collapse" :duration="400">
            <CButton @click="emptyAnaKathhghth()" variant="ghost" color="dark" class="px-2">Απόκρυψη</CButton>
        </CCollapse>
        <div v-for="entry in mathhmataAnaKathghth.records" :key="entry.id">
            <CCard>
                <CCardHeader>
                    <strong>Τίτλος μαθήματος:</strong>{{entry.title}}
                    <br>
                    <strong>Κωδικός e-class:</strong>{{entry.eclass_code}}
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
            mathhmataAnaTmhma:[],
            kathhghtes:[],
            mathhmataAnaKathghth:[],

            id:'',
            
            collapse: false,
            collapse1 : false
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

        getMathhmataAnaTmhma()
        {
            axios.post("http://localhost/restapi/api/modip/getMathhmataAnaTmhma.php",{id:this.id})
            .then(response => this.mathhmataAnaTmhma = response.data)
            .catch(error => {
            this.erroMessage = error.message;
            console.error("There was an error!", error);
        })
        },

        getKathhghtes()
        {
            axios.post("http://localhost/restapi/api/modip/getKathhghtes.php")
            .then(response => this.kathhghtes = response.data)
            .catch(error => {
            this.erroMessage = error.message;
            console.error("There was an error!", error);
        })
        },

        getMathhmataAnaKathhghth()
        {
            axios.post("http://localhost/restapi/api/modip/getMathhmataAnaKathhghth.php",{id:this.id})
            .then(response => this.mathhmataAnaKathghth = response.data)
            .catch(error => {
            this.erroMessage = error.message;
            console.error("There was an error!", error);
        })
        },

        emptyAnaKathhghth() {
            this.mathhmataAnaKathghth = [];
            this.collapse = false;
        },

        emptyAnaTmhma() {
            this.mathhmataAnaTmhma = [];
            this.collapse1 = false;
        }
    },

    mounted(){
        this.getTmhmata();
        this.getKathhghtes();
    }

}
    
</script>
