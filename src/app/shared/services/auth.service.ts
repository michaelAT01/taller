import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable, retry, tap, of, BehaviorSubject } from "rxjs";
import { map, catchError } from 'rxjs/operators';
import { environment } from "../../../environments/environment";
import { Token } from "../models/token";
import { TokenService } from "./token.service";
import { User } from "../models/user";
import { Router } from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private usrActualSubject = new BehaviorSubject<User>(new User());
  public usrActual = this.usrActualSubject.asObservable();

  constructor(private http: HttpClient, private srvToken: TokenService, private router: Router) { }

  public login(user: { usr: '', passw: '' }): Observable<any> {
    return this.http.post<Token>(`${environment.SRV}/auth/iniciar`, user)
      .pipe(
        retry(1),
        tap(tokens => {
          console.log(tokens)
          this.doLogin(tokens)
          this.router.navigate(['/home'])
        }),
        map(() => true),
        catchError(
          error => { return of(error.status) }
        )
      )
  }

  public get valueUrsActual(): User {
    return this.usrActualSubject.value
  }

  public loggout() {
    this.http.patch(`${environment.SRV}/auth/cerrar`, {
      "idUsuario": this.valueUrsActual.usr
    }).subscribe();
    this.doLogout()
  }

  private doLogin(tokens: Token): void {
    this.srvToken.setTokens(tokens);
    this.usrActualSubject.next(this.getActualUser());
  }

  public isLogged(): boolean {
    return !!this.srvToken.token && !this.srvToken.jwtTokenExp();
  }

  private doLogout() {
    if (this.srvToken.token) {
      this.srvToken.deleteTokens();
    }
    this.usrActualSubject.next(this.getActualUser())
  }


  private getActualUser(): User {
    if (!this.srvToken.token) {
      return new User();
    }
    const tokenD = this.srvToken.decodeToken();
    return { usr: tokenD.sub, rol: tokenD.rol, nom: tokenD.nom }
  }

  public verifyRefresh(): boolean {
    if (this.isLogged() && this.srvToken.timeExpToken() <= 20) {
      this.srvToken.refreshTokens();
      return true;
    } else {
      return false
    }
  }

}
