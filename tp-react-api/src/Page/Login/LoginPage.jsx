import LoginForm from "../../Component/LoginForm/LoginForm";
import {useState} from "react";


const LoginPage = () => {

    const [ formSubmitting, setFormSubmitting ] = useState(false);
    const handleSubmit = async (credentials) => {
        setFormSubmitting(true);
        try {
            //TODO Make Login call
        } catch (error) {
            console.log(error);
            // message
        } finally {
            setFormSubmitting(false);
        }
    };

    return(
        <div>

            <LoginForm
                handleSubmit={handleSubmit}
            />

        </div>
    )
}

export default LoginPage;