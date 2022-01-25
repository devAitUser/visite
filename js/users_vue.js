new Vue({
    el: '#app_users',
    vuetify: new Vuetify(),

    data() {

        return {
            dialog: false,
            expanded: [],
            dialog_add: false,
            singleExpand: true,
            nameRules: [
                v => !!v || 'Le Champs Nom est obligatoire',
            
              ],
              emailRules: [
                v => !!v || 'Le Champs Nom est obligatoire',
                v => /.+@.+\..+/.test(v) || 'Email doit être valide',
            
              ],
              rules: {
                required: v => !!v || 'this field is required',
              },
              passwordRules: [
                v => !!v || 'Le Champs Nom est obligatoire',
            
              ],
              roleRules: [
                v => !!v || 'Le Champs Nom est obligatoire',
            
              ],
              
            
              valid: true,
            pagination: {
                rowsPerPage: 5,

            },
           
            search_project: null,

            role_items: [

            ],
            user_a: {
                id: 0,
                name: '',
                email: '',
                roles: [{
                    name: '',
                    color: ''
                }],
                select: null,
                password: '',
                project_id : null
            },
            btn_control: false,
            singleSelect: false,
            selectedRows: [],
            selected: [],
            search: '',
            sortBy: 'id',
            sortDesc: true,

            headers: [

                {
                    text: 'Id',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },

                {
                    text: 'Nom',
                    value: 'name'
                },
                {
                    text: 'Email',
                    value: 'email'
                },
                {
                    text: "roles",
                    value: "roles",
                },
                {
                    text: "Action",
                    value: "action",
                    sortable: false
                }

            ],

            users: [

            ],
            editedIndex: -1,
            editedItem: {
                id: 0,
                name: '',
                email: '',
                roles: [{
                    name: '',
                    color: '',
                    id: ''
                }],
                select: {
                    id: '',
                    name: ''
                },
                password: '',
                project_id : []

            },
            defaultItem: {
                id: 0,
                name: '',
                email: '',
                roles: [{
                    name: '',
                    color: '',
                    id: ''
                }],
                select: {
                    id: '',
                    name: ''
                },
                password: ''
            },

        }
    },


    methods: {


        checkDuplicate(val) {

            var check = false ;

      
            for (i = 0; i < this.users.length; i++) {
                var check_email =this.users[i].email

                if (val == check_email ) {
    
                    check = true
                    break;
                  
                   } else {
                    check = false
                   }
    

               }

             


               if (check ==  true) {
                return `Email "${val}" existe déjà`;
               } else {
                 return true;
               }

 
           
          
            
          },


        resetValidation () {
            this.$refs.form.resetValidation()
            this.user_a.name = "";

            this.user_a.email = "";

            this.user_a.roles[0].name = "";
            this.user_a.roles[0].color = "";


            this.user_a.password = "";
            this.user_a.select = "";
   
          },
          
        validate () {
            
            
            if(this.$refs.form.validate()==true){
                this.add()

            }
            
          },

    

        get_color(name , color ) {


            var role_print = '<a style="background-color: ' + color + ';" class="badge badge-primary  p-2">' + name + '</a>';

            return role_print;
        },

        clicked(value) {
            const index = this.expanded.indexOf(value)



            if (index === -1) {
                this.expanded.push(value)

            } else {
                this.expanded.splice(index, 1)
            }

        },

        editItem(item) {

            window.location.href = "user/" + item.id + "/edit"
        },

        save() {

            if (this.editedIndex > -1) {
                console.log(this.editedItem);
                
                Object.assign(this.users[this.editedIndex], this.editedItem)
               
                this.update_user(this.editedItem)
               

            } else {
                this.users.push(this.editedItem);
          
            
            }

            this.close()

        },

        close() {

            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1

            })
            this.expanded = [];

        },

        item: function(values) {

            if (values.length > 0) {

                this.btn_control = true;

            } else {
                this.btn_control = false;

            }


        },
        delete_single_Item(item) {

            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "voulez vous vraiment  supprimé",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Retour',
                confirmButtonText: 'Oui, Supprimé !'
            }).then((result) => {
                if (result.value) {

                  

                        axios.delete(window.laravel.url + '/delete_user/' + item.id)
                            .then(response => {

                            })
                            .catch(error => {
                                console.log(error);
                            })

                        const index = this.users.indexOf(item);


                        this.users.splice(index, 1);
                    
                 




                    this.btn_control = false;

                    Swal.fire({

                            title: 'Supprimer!',
                            html: 'Votre experience été supprimer aver succes.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,


                            onBeforeOpen: () => {

                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }


                        }

                    )
                }
            })



        },

        deleteItem() {

            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "voulez vous vraiment  supprimé",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Retour',
                confirmButtonText: 'Oui, Supprimé !'
            }).then((result) => {
                if (result.value) {

                    for (var i = 0; i < this.selected.length; i++) {

                        axios.delete(window.laravel.url + '/delete_user/' + this.selected[i].id)
                            .then(response => {

                            })
                            .catch(error => {
                                console.log(error);
                            })

                        const index = this.users.indexOf(this.selected[i]);


                        this.users.splice(index, 1);
                    }
                    this.selected = [];




                    this.btn_control = false;

                    Swal.fire({

                            title: 'Supprimer!',
                            html: 'Votre experience été supprimer aver succes.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,


                            onBeforeOpen: () => {

                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }


                        }

                    )
                }
            })



        },
     
        add: function() {

            var value_projet_id = [];
            let jsonData = new FormData()
            jsonData.append('name', this.user_a.name)
            jsonData.append('email', this.user_a.email)
            jsonData.append('password', this.user_a.password)
            jsonData.append('role_id', this.user_a.select.id)


            for ( var i = 0; i < this.user_a.project_id.length; i++) {
                value_projet_id[i] = this.user_a.project_id[i].id;
              }
              

             jsonData.append('projet_id', value_projet_id); 
             


            axios.post(window.laravel.url + '/user_post', jsonData)
                .then(response => {
                    console.log(response.data);

                    if (response.data.etat) {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Ajouté avec succes'
                        })
                        this.user_a.id = response.data.id_user;
                        this.user_a.roles[0].name = response.data.name;
                        this.user_a.roles[0].color = response.data.color;




                        this.users.unshift(this.user_a);

                        this.user_a = {
                            id: 0,
                            name: '',
                            email: '',
                            role: '',
                            password: ''

                        };
                        this.dialog_add = false;

                    }


                })
        },
        remove_item() {

            if (this.btn_control) {
                this.deleteItem();
            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Au moins un élément doit être sélectionné!',
                })

            }

        },

        check_role(role){

          

            if (role == undefined){

                return false;
            } else  if (role !== undefined){
                return true;

            }
            


            

             

        },

        get_data: function() {

            axios.get(window.laravel.url + '/get_users/')
                .then(response => {

                    this.users = response.data.users;



                    this.role_items = response.data.roles_all;


                
           





                



                })
                .catch(error => {
                    console.log(error);
                })

            axios.get(window.laravel.url + '/product/getsite/')
                .then(response => {

                    this.items_project = response.data.sites;


                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
    mounted: function() {

        this.get_data();



    }



})