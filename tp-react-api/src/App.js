import './App.css';

export function RequireAuth({ children }) {
    // Used to ensure the refreshToken is called once at a time
    const user = ???; // TODO Get user from local storage

    if (user === null) {
        //TODO Navigate to login
    } else {
        return children;
    }
}

function App() {

//Navigation dans requireAuth
  return (
      //TODO ROUTER
      <div></div>
  );
}

export default App;
