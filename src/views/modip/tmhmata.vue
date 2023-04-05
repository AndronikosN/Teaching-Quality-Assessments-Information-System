<template>
    <div>
        <h1><strong>Τμήματα ιδρύματος:</strong></h1>
        <CCard v-for="entry in tmhmata" :key="entry.value">
            <CCardHeader>
                <strong>{{entry.label}}</strong>
            </CCardHeader>
            <CCardFooter>
                <strong>Πόλη:</strong>{{entry.city}}
            </CCardFooter>
        </CCard>
    </div>
    
</template>

<script>
import axios from 'axios';

export default {
    
    data(){
        return{
            tmhmata:[],
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
        }

    },

    mounted(){
        this.getTmhmata()
    }
}
</script>
