import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {AuthService} from "../../shared/services/auth.service";
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  frmLogin : FormGroup;
  errLogin : boolean = false;

  constructor(private  fb : FormBuilder, private  authSrv : AuthService) {
    this.frmLogin = this.fb.group({
      idUsuario : ['C12345', Validators.required],
      passw : ['C12345', Validators.required]
    })
  }

  onSubmit() {
    console.log(this.frmLogin.value)
    this.authSrv.login(this.frmLogin.value)
      .subscribe( res => {
        this.errLogin = (!res || res === 401)
      }
      )
  }



  ngOnInit(): void {
  }

}
