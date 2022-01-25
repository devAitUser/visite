new Vue({
    el: '#app_roles',
    vuetify: new Vuetify(),

    data() {

        return {
            dialog: false,
            expanded: [],
            nameRules: [
                v => !!v || 'Le Champs Nom est obligatoire',
            
              ],
              valid: true,
            dialog_add: false,
            singleExpand: true,
            pagination: {
                rowsPerPage: 5,

            },
            role_a: {
                id: 0,
                slug: '',
                name: '',
                color: '',
                
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
                    text: 'slug',
                    value: 'slug'
                }
                ,
                {
                    text: "Colour ",
                    value: "color",
                    sortable: false,
                }

                ,
                {
                    text: "Action",
                    value: "action",
                    sortable: false
                }

            ],

            role: [

            ],
            editedIndex: -1,
            editedItem: {
                id: 0,
                slug: '',
                name: '',
                color: '',

            },
            defaultItem: {
                id: 0,
                slug: '',
                name: '',
                color: '',
            },

        }
    },


    methods: {

      
        resetValidation () {
            this.$refs.form.resetValidation()
          },
         validate () {
        this.$refs.form.validate()
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
            this.editedIndex = this.role.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true

        },

        save() {

            if (this.editedIndex > -1) {
                Object.assign(this.role[this.editedIndex], this.editedItem)
                this.update_role(this.editedItem)

            } else {
                this.role.push(this.editedItem)
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

                        axios.delete(window.laravel.url + '/deleterole/' + this.selected[i].id)
                            .then(response => {

                            })
                            .catch(error => {
                                console.log(error);
                            })

                        const index = this.role.indexOf(this.selected[i]);


                        this.role.splice(index, 1);
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
        update_role: function(item_object) {



            axios.put(window.laravel.url + '/updaterole', item_object)
                .then(response => {
                    console.log(response.data);

                })
                .catch(error => {
                    console.log(error);
                })

        },

        add: function() {

            this.validate()
            let jsonData = new FormData()
            jsonData.append('name', this.role_a.name)
            jsonData.append('slug', this.role_a.slug)
            jsonData.append('color', this.role_a.color)

          
            console.log(jsonData);

            axios.post(window.laravel.url + '/postrole', jsonData)
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
                        this.role_a.id = response.data.id_role;
                        this.role.unshift(this.role_a);

                        this.role_a = {
                            id: 0,
                            nom: '',
                            slug:''


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
        set_slug: function () {

            

           var slug = this.role_a.name.replace(/\s/g, '-') ;
            slug = slug.toLowerCase();
           this.role_a.slug = slug;
          },

        get_data: function() {

            
           
            axios.get(window.laravel.url + '/getroles/')
                .then(response => {
                
                    this.role = response.data.roles;


             


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