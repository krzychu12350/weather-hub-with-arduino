export default function authHeader() {
  let user = JSON.parse(localStorage.getItem('user'));

  if (user && user.access_token) {
    return { headers: { Authorization: 'Bearer ' +
                                   user.access_token,
                                   'Content-Type': 'application/json',
                                   //'Access-Control-Allow-Origin': 'http://localhost:8000',
                                   //'Access-Control-Allow-Credentials': 'true'
                                    }}; // for Spring Boot back-end
    //return { 'x-access-token': user.accessToken };       // for Node.js Express back-end
  } else {
    return {};
  }
}
