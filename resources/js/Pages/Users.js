import axios from "axios";
import Swal from "sweetalert2";


export class Users {
  constructor() {
    this.load();
  }

  load() {
    this.events();
    this.getData();
  }

  events() {
    let self = this;

    $("body").on("click", ".saveUserBtn", function () {
      self.saveUser();
    }).on("click", ".delUserBtn", function () {
      const user_id = $(this).attr('data_id');
      self.delUser(user_id);
    }).on("click", ".editUserBtn", function () {
      const id = $(".selected").attr("data-id");
      console.log(id);
      if (id == undefined) {
        Swal.fire("Hata", "Lütfen bir kullanıcı seçiniz", "error");
        return;
      }
      window.location.href = "/users/edit/" + id;
    })
      .on("click", ".delUserBtn", function () {
        const id = $(".selected").attr("data-id");
        console.log(id);
        if (id == undefined) {
          Swal.fire("Hata", "Lütfen bir kullanıcı seçiniz", "error");
          return;
        }
        self.delUser(id);
      })



  }

  getData() {
    const table = $("#usersTable").DataTable({
      processing: true,
      serverSide: true,
      destroy: true,
      scrolly:"44vh",
      ajax: {
        url: "/api/users/getData",
        type: "GET"
      },
      columns: [
        { data: "name", name: "name" },
        { data: "email", name: "email" },
        { data: "phone", name: "phone" },
        { data: "status_name", name: "status_name" },
        { data: "action", name: "action" }
      ],
      createdRow: function (row, data) {
        $(row).attr("data-id", data.id);
      }
    });

    $("#usersTable tbody").off("click", "tr").on("click", "tr", function () {
      if ($(this).hasClass("selected")) {
        $(this).removeClass("selected");
      } else {
        table.$("tr.selected").removeClass("selected");
        $(this).addClass("selected");
      }
    });
  }

  async saveUser() {
    const userdata = {
      name_surname: $('.name_surname').val(),
      email: $('.email').val(),
      phone: $('.phone').val(),
      status: $('.status').val(),
      password: $('.password').val(),
      password_rep: $('.password_rep').val(),
      user_id: $(".user_id").val(),
    };

    console.log(userdata);

    try {
      const { data } = await axios.post('/api/users/saveUser', userdata);

      if (data && data.status) {
        Swal.fire({ title: 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          window.location.href = '/users';
        })
      } else {
        Swal.fire('Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);

      Swal.fire(
        'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }
  }

  async delUser(user_id) {
    const self = this
    const onay = await Swal.fire({
      title: "Emin misiniz?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Evet",
      cancelButtonText: "Hayır"
    });

    if (!onay.isConfirmed) return;
    const { data } = await axios.post('/api/users/delUser', { user_id: user_id });

    if (data && data.status) {
      Swal.fire({ title: 'Bilgi', text: data.message, icon: 'success' }).then(() => {

      })
      self.getData();
    } else {
      Swal.fire('Hata', data.message || 'Bir hata oluştu', 'error');
    }

  }
}

window.Users = Users;