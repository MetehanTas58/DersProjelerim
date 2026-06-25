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

    $("body")
      .off("click", ".saveUserBtn")
      .on("click", ".saveUserBtn", function () {
        self.saveUser();
      })
      .off("click", ".rowDelUserBtn")
      .on("click", ".rowDelUserBtn", function (e) {
        e.preventDefault();
        const user_id = $(this).attr('data_id');
        self.delUser(user_id);
      })
      .off("click", ".topEditUserBtn")
      .on("click", ".topEditUserBtn", function () {
        const id = $(".selected").attr("data-id");
        if (id == undefined) {
          Swal.fire("Hata", "Lütfen bir kullanıcı seçiniz", "error");
          return;
        }
        window.location.href = "/users/edit/" + id;
      })
      .off("click", ".topDelUserBtn")
      .on("click", ".topDelUserBtn", function () {
        const id = $(".selected").attr("data-id");
        if (id == undefined) {
          Swal.fire("Hata", "Lütfen bir kullanıcı seçiniz", "error");
          return;
        }
        self.delUser(id);
      });
  }

  getData() {
    $(".topEditUserBtn, .topDelUserBtn").prop("disabled", true);

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

    $("#usersTable tbody").off("click", "tr").on("click", "tr", function (e) {
      if ($(e.target).closest("a, button").length > 0) {
        return;
      }

      if ($(this).hasClass("selected")) {
        $(this).removeClass("selected");
        $(".topEditUserBtn, .topDelUserBtn").prop("disabled", true);
      } else {
        table.$("tr.selected").removeClass("selected");
        $(this).addClass("selected");
        $(".topEditUserBtn, .topDelUserBtn").prop("disabled", false);
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