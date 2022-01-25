new Vue({
    el: '#app_client',
    vuetify: new Vuetify(),

    data() {

        return {
            dialog: false,
            dialog_add: false,
            expanded: [],
            valid: true,
            singleExpand: true,
            pagination: {
                rowsPerPage: 5,

            },
            nameRules: [
                v => !!v || 'Le Champs Nom est obligatoire',
            
              ],
              phoneRules: [
                v => !!v || 'Le Champs Telephone est obligatoire',
            
              ],
              adresseRules: [
                v => !!v || 'Le Champs Adresse est obligatoire',
            
              ],
            client_a: {
                id: 0,
                nom: '',
                telephone: '',
                adresse : '',
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
                    value: 'nom'
                },
                {
                    text: 'Telephone',
                    value: 'telephone'
                },
                
                {
                    text: 'Adresse',
                    value: 'adresse'
                },
                {
                    text: "Action",
                    value: "action",
                    sortable: false
                }

            ],

            clients: [

            ],
            editedIndex: -1,
            editedItem: {
                id: 0,
                nom: '',
                telephone: '',
                adresse : '',

            },
            defaultItem: {
                id: 0,
                nom: '',
                telephone: '',
                adresse : '',
            },

        }
    },


    methods: {

        resetValidation () {
            this.$refs.form.resetValidation()
            this.client_a.nom = "";
            this.client_a.telephone = "";
            this.client_a.adresse = "";
          },
        validate () {
            
            
            if(this.$refs.form.validate()==true){
                this.add()

            }
            
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
            
            this.editedIndex = this.clients.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true

        },

        save() {

            if (this.editedIndex > -1) {
                Object.assign(this.clients[this.editedIndex], this.editedItem)
                this.update_client(this.editedItem)

            } else {
                this.clients.push(this.editedItem)
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
        remove_item() {

            if(this.btn_control){
                this.deleteItem();
            }
            else{

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Au moins un élément doit être sélectionné!',
                  })

            }

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

                        axios.delete(window.laravel.url + '/deleteclient/' + this.selected[i].id)
                            .then(response => {

                            })
                            .catch(error => {
                                console.log(error);
                            })

                        const index = this.clients.indexOf(this.selected[i]);


                        this.clients.splice(index, 1);
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
        update_client: function(item_object) {


                console.log(item_object);
            axios.put(window.laravel.url + '/updateclient', item_object)
                .then(response => {
                    
                    console.log(response.data);

                })
                .catch(error => {
                    console.log(error);
                })

        },

        add: function() {

    
            let jsonData = new FormData()
            jsonData.append('nom', this.client_a.nom)
            jsonData.append('telephone', this.client_a.telephone)
            jsonData.append('adresse', this.client_a.adresse)

            

            axios.post(window.laravel.url + '/postclient', jsonData)
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
                        this.client_a.id = response.data.id_client;
                        this.clients.unshift(this.client_a);
                        this.dialog_add= false;

                        this.client_a = {
                            id: 0,
                            nom: '',
                            telephone: '',
                            adresse : '',


                        };

                    }


                })
        },

        get_data: function() {
            
            axios.get(window.laravel.url + '/getclient/')
                .then(response => {
             
                    this.clients = response.data.clients;


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