<form action="/" class="d-flex">
    <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>&nbsp;&nbsp;
      @guest
      <a href="{{route('login')}}" class="btn btn-outline-success">Login</a>&nbsp;&nbsp;

      <a href="{{route('registration')}}" class="btn btn-outline-success">SignUp</a>
      @else

          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item dropdown rounded">
                  <a class="nav-link dropdown-toggle btn btn-outline-success" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}</a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="/cart">Cart</a></li>
                    <li><a class="dropdown-item" href="/user-order/order-list">Your Order</a></li>
                    <li><a href="{{route('logout')}}" class="dropdown-item">Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          </ul>
      @endguest

  </form>
