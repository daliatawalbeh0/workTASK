import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

const Login = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState(null);
  const navigate = useNavigate();  // Hook to navigate to different routes

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formData = {
      email,
      password,
    };

    try {
      const response = await axios.post('http://localhost:8000/api/login', formData);
      const { token, user } = response.data;

      // Store the token in localStorage for future requests
      localStorage.setItem('auth_token', token);

      // Set token in Axios defaults for future requests
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

      // Redirect user based on their role
      if (user.role_id === 1) {
        // Admin role
        navigate('/admin-dashboard');
      } else if (user.role_id === 2) {
        // Manager role
        navigate('/manager-dashboard');
      } else {
        // User role
        navigate('/user-dashboard');
      }
    } catch (error) {
      setError(error.response?.data?.message || 'Login failed');
    }
  };

  return (
    <div>
      <form onSubmit={handleSubmit}>
        <input
          type="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          placeholder="Email"
          required
        />
        <input
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          placeholder="Password"
          required
        />
        <button type="submit">Login</button>
      </form>
      {error && <p>{error}</p>}
    </div>
  );
};

export default Login;
