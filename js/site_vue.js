new Vue({
    el: '#app_site',
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
              valid: true,
            pagination: {
                rowsPerPage: 5,

            },
            site_a: {
                id: 0,
                nom: '',
                date_create : new Date().toISOString().slice(0, 10),
                total : 0
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
                    text: 'Date de creation',
                    value: 'date_create'
                },
                {
                    text: "Total",
                    value: "total",
                }
                ,
                {
                    text: "Action",
                    value: "action",
                    sortable: false
                }

            ],

            site: [

            ],
            editedIndex: -1,
            editedItem: {
                id: 0,
                nom: '',
                date_create: '',
            },
            defaultItem: {
                id: 0,
                nom: '',
                date_create: '',
            },

        }
    },


    methods: {

        resetValidation () {
            this.$refs.form.resetValidation()
            this.site_a.nom = ""
   
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
   
            this.editedIndex = this.site.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true

            

        },

        save() {

            if (this.editedIndex > -1) {
                Object.assign(this.site[this.editedIndex], this.editedItem)
                this.update_site(this.editedItem)

            } else {
                this.site.push(this.editedItem)
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

                        axios.delete(window.laravel.url + '/product/deletesite/' + this.selected[i].id ,  {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        }).then(response => {

                            })
                            .catch(error => {
                                console.log(error);
                            })

                        const index = this.site.indexOf(this.selected[i]);


                        this.site.splice(index, 1);
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
        update_site: function(item_object) {



            axios.put(window.laravel.url + '/product/updatesite', item_object)
                .then(response => {
                    console.log(response.data);

                })
                .catch(error => {
                    console.log(error);
                })

        },

        add: function() {
            let jsonData = new FormData()
            jsonData.append('nom', this.site_a.nom)
            jsonData.append('date_create', this.site_a.date_create)

            axios.post(window.laravel.url + '/product/postsite', jsonData)
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
                        this.site_a.id = response.data.id_site;
                        this.site.unshift(this.site_a);

                        this.site_a = {
                            id: 0,
                            nom: '',
                            date_create: new Date().toISOString().slice(0, 10),


                        };
                        this.dialog_add =false;

                    }


                })
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

        get_data: function() {


           
            axios.get(window.laravel.url + '/product/getsite/')
                .then(response => {
         
                    this.site    = response.data.sites;

             
            

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