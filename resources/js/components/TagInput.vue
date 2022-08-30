<template>
  <div class="tags-input-container ">

        <div class="row">

            
            <div class="col-md-12 w-50 mx-auto">

                <div class="contact-form-success alert alert-success mt-4 text-center" v-if="success_message">
                     {{success_message }}
                </div>

                <div id="error" class="contact-form-error alert alert-danger mt-4 text-center" v-if="message">                
                    {{ message }}
                </div>
            </div>

        </div>
 
        <div class="row mb-3">


            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

            <div class="col-md-6 tag-container form-control">
                    <div class="tag" v-for="(tag, index) in tags" :key="'tag'+index">
                        <span v-if="activeTag !== index" @click="activeTag = index">{{ tag }}</span>
                        <input v-else 
                                v-model="tags[index]" 
                                v-focus 
                                :style="{'width': tag.length + 'ch'}" 
                                @keyup.enter="activeTag = null" 
                                @blur="activeTag = null" />
                        <span @click="removeTag(index)"><i class="fas fa-window-close"></i></span>
                    </div>
                <input :disabled="message != ''" class="" :class="hasError('email') ? 'is-invalid' : ''" name="email" type="email" v-model="tagValue" @keyup.enter="addTag" autocomplete="off">
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                
                <button :disabled="message != ''" @click="onSubmit" type="submit" class="btn btn-primary">
                Invite
                </button>&nbsp;
                <img class="spinner" :class="{ show }" src="/images/spinner.gif" style="max-width: 100px;">
            </div>
        </div>
   
  </div>
</template>

<script>
import axios from 'axios';

  export default {
    data: () => {
      return {
        success: false,
        error: false,
        message: '',
        success_message: '',
        errors: {},
        tagValue: '',
        tags: [],
        activeTag: null,
        show: ''
       
      }
    },
    created () {
       
    },
    methods: {
        addTag() {
            if(!this.tagValue == '')

            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.tagValue)) {

                axios.post('/referrals', {
                        emailtag: this.tagValue
                    })
                    .then((res) => {
                       // this.onSuccess(res.data.message);

                       if(res.data.message) {
                         this.message = res.data.message;
                          console.log(res.data.message);
                       }
                       
                      
                    })
                    .catch((error) => {


                         console.log(error.response);
                        if(error.response.status == 422) {
                             //console.log(error.response);
                            //this.setErrors(error.response.data.errors);

                        } else {


                            //console.log(error.response);
                            //this.onFailure(error.response.data.message);

                        }

                        
                      
                    })

                this.tags.push(this.tagValue);
                this.tagValue = '';
                this.success_message = "";

            } else {
                alert('Please enter a valid email address') ;
            }
           
            
          
        },
        onSubmit(){

            this.show = "show";

            axios.post('/referrals/submitemail', {
                emailtag: this.tags
            })
            .then((res) => {

           

                if(this.tags != "") {

                    this.success_message = res.data.success_message;
                    this.tags = [];
                    console.log(res.data.success_message);

                  

                } else if(this.tags == "") {

                    
                      this.success_message = "Please type Email then press Enter to select Email..";
                   

                } else {
                    
                    this.success_message= "No Email Sent!";
                }

                 this.show = "";
            })
            .catch((error) => {


                
                
            })
            
        },
        onSuccess(message) {
            this.success = true;
        },
        onFailure(message) {
            this.error = true;
        },
        setErrors(errors) {
            this.errors = errors;
        },
        removeTag(index) {
            this.tags.splice(index, 1);
            
            if(  this.tags.splice(index, 1)) {
                 this.message = "";
            }
           
        },
        hasError(fieldName) {
            return (fieldName in this.errors);
        }
   
    },
 
    directives: {
      focus: {
        inserted: (el) => {
          el.focus()
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .tags-input-container {
    width: 100%;

    padding: 10px;
    background-color: rgba($color: #ffffff, $alpha: .7);

    .tag-container.form-control {
            flex: 0 0 auto;
        width: 50%;
    }
    
    input {
      width: 200px;
       border: none;
       background: transparent;
      margin: 0;
      padding: 0 0.75rem;
      font-size: 1rem;
    }

    input:focus,
    input:active {
         border: none;
       background: transparent;
       outline: none;
    }

    .tag {
      float: left;
      padding: 5px 5px;

      display: flex;
      justify-content: center;
      cursor: pointer;
        background: #ccc;
        margin-bottom: 10px;
        border-radius: 5px;
        margin-right: 5px;

      &:hover {
        background-color: #57c340;
        border-radius: 5px;
      } 

      span:first-child {
        margin-right: 8px;
      }  

      svg {
        color: #666;

        &:hover {
          color: #333;
        }
      }     
    }
  }

  .spinner {
    display: none;
  }

   .spinner.show {
    display: inline-block;
  }
</style>