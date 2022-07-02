import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor
} from '@angular/common/http';
import { Observable } from 'rxjs';
import {AuthService} from "../services/auth.service";
import {TokenService} from "../services/token.service";

@Injectable()
export class JwtInterceptor implements HttpInterceptor {

  constructor(private srvAuth : AuthService, private srvToken : TokenService) {}

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    if(this.srvAuth.isLogged()){
      request = request.clone({
        setHeaders : {
          Authorization : `Bearer ${this.srvToken.token}`
        }
      })
    }
    return next.handle(request);
  }
}
