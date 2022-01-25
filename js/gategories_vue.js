new Vue({
    el: '#app_gategorie',
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
            gategorie_a: {
                id: 0,
                nom: '',
                total: 0,
                date_create: new Date().toISOString().slice(0, 10),
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
                    value: 'date_create',
                    dataType: "Date"
                }, 
                {
                    text: "Total",
                    value: "total"
                }
                , 
                {
                    text: "Action",
                    value: "action",
                    sortable: false
                }

            ],

            gategorie: [

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
            this.gategorie_a.nom = "";
   
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
            this.editedIndex = this.gategorie.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true

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

        save() {

            if (this.editedIndex > -1) {
                Object.assign(this.gategorie[this.editedIndex], this.editedItem)
                this.update_gategorie(this.editedItem)

            } else {
                this.gategorie.push(this.editedItem)
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

                        axios.delete(window.laravel.url + '/product/deletegategorie/' + this.selected[i].id)
                            .then(response => {

                            })
                            .catch(error => {
                                console.log(error);
                            })

                        const index = this.gategorie.indexOf(this.selected[i]);


                        this.gategorie.splice(index, 1);
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
        update_gategorie: function(item_object) {



            axios.put(window.laravel.url + '/product/updategategorie', item_object)
                .then(response => {
                    console.log(response.data);

                })
                .catch(error => {
                    console.log(error);
                })

        },

        add: function() {
            let jsonData = new FormData()
            jsonData.append('nom', this.gategorie_a.nom)
            jsonData.append('date_create', this.gategorie_a.date_create)



            axios.post(window.laravel.url + '/product/postgategorie', jsonData)
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
                        this.gategorie_a.id = response.data.id_cate;
                        this.gategorie.unshift(this.gategorie_a);
                        this.dialog_add =false;

                        this.gategorie_a = {
                            id: 0,
                            nom: '',
                            date_create: new Date().toISOString().slice(0, 10),


                        };

                    }


                })
        },

        get_data: function() {
            axios.get(window.laravel.url + '/product/getgategorie/')
                .then(response => {

                    this.gategorie = response.data.gategories;


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