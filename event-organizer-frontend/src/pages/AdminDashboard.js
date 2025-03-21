import React, { useState, useEffect } from 'react';
import axios from 'axios';

const handleLogout = () => {
    // Remove the token from localStorage
    localStorage.removeItem('auth_token');
  
    // Optionally, you can clear axios headers for the token
    delete axios.defaults.headers.common['Authorization'];
  
    // Redirect the user to the login page
    window.location.href = '/'; // Or use your router to navigate
  };
  
const AdminDashboard = () => {


  return (
    <div>
      <h1>OrgnizerDashboard</h1>
 
      <button onClick={handleLogout}>Logout</button>  {/* زر تسجيل الخروج */}
    </div>
  );
};

export default AdminDashboard;