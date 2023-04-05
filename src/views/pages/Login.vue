<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="8">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm @submit.prevent="login">
                  <h1>Login</h1>
                  <p class="text-muted">Sign In to your account</p>
                  <CInput
                    placeholder="Username"
                    autocomplete="username email"
                    v-model="username"
                    :is-valid="validator"
                    
                    invalid-feedback="Δωστε username"
                  >
                    <template #prepend-content><CIcon name="cil-user"/></template>
                  </CInput>
                  
                  <CInput
                    placeholder="Password"
                    type="password"
                    autocomplete="curent-password"
                    v-model="password"
                    :is-valid="validator"
                    
                    invalid-feedback="Δώστε password"
                  >
                    <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                  </CInput>
                  <CRow>
                    <CCol col="6" class="text-left">
                      <CButton color="primary" class="px-4" type="submit">Login</CButton>
                    </CCol>
                   
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
            
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>

import axios from 'axios';


export default {
  name: 'Login',

  data() {
    return {
      username: '',
      password:''
      
    
    }
  },

  methods: {
    login() {
             
     
        axios.post("http://localhost/restapi/api/login/login.php",{username:this.username,password:this.password})
        .then(resp=>{
        if(resp.data.res==1){
             localStorage.setItem('token',resp.data.jwt);
             localStorage.setItem('type',resp.data.utype);
             localStorage.setItem('student_am',resp.data.am);
             localStorage.setItem('prof_id',resp.data.id);
             localStorage.setItem('tmhma_id',resp.data.tmhma_id)
      this.$router.push('/')
        }else{
          alert("LATHOS");
        }
        })
        .catch(err => console.log(err));
        
    },
    validator (val) {
      return val ? val.length >= 1 : false
    },
  },

}
</script>
