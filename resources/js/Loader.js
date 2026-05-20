import { Login } from "./Pages/Login";
import { Users } from "./Pages/Users";
import { Blog } from "./Pages/Blog";

export class Loader {

    constructor() {

    }

    load(ModuleName = "") {

    };

    setModule(ModuleName) {

        if ($(".menu-page").length)
            return true

        try {
            if (ModuleName == "") return false;
            if (eval('app.' + ModuleName + '') != undefined) {
                eval('app.' + ModuleName + '.load();')
                return
            }

            var cls = this.newclass(ModuleName)
            if (cls != null) {
                eval('app.' + ModuleName + ' = cls;');
                eval('app.' + ModuleName + '.firstload = true;');
                eval('app.' + ModuleName + '.eventsload = true;');
                eval('app.' + ModuleName + '.dropzone = null;');

                this.default_settings();
                return true
            } else {
                return false
            }
        } catch (err) {
            console.error(err)
            return false;
        }
    }
    newclass(ModuleName) {
        switch (ModuleName) {
            case "Login":
                return new Login;
            case "Users":
                return new Users();
            case "Blog":
                return new Blog();

            default:
                return null;
        }
    }

    default_settings() {
        setTimeout(() => {
            $("input:not([autocomplete])").attr("autocomplete", "off");
            $("select:not([autocomplete])").attr("autocomplete", "off");
        }, 1500);
    }

    setConfig() {
        if (this.configset)
            return

        this.configset = true
    }

}