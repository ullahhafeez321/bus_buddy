import React, { useState } from 'react';
import { StyleSheet, TextInput, Button, Alert, View, Image, Text, TouchableOpacity } from 'react-native';
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { useRouter } from 'expo-router';

export default function LoginScreen() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const router = useRouter();

  const handleLogin = async () => {
    if (email === '' || password === '') {
      Alert.alert('Error', 'Please enter both email and password');
      return;
    }

    try {
      const response = await axios.post('http://192.168.25.161:8000/api/login', {
        email,
        password,
      });
      console.log(response.data);

      const { token, role } = response.data;

      await AsyncStorage.setItem('authToken', token);
      await AsyncStorage.setItem('userRole', role);

      if (role === 'driver') {
        router.replace('/home');
      } else if (role === 'student') {
        router.replace('/home');
      } else {
        Alert.alert('Error', 'Role not recognized');
      }
    } catch (error) {
      if (error.response && error.response.data) {
        Alert.alert('Error', error.response.data.message || 'Wrong Credentials');
      } else if (error.request) {
        Alert.alert('Error', 'Network error, please try again later');
      } else {
        Alert.alert('Error', error.message || 'An unknown error occurred');
      }
    }
  };

  return (
    <View style={styles.container}>
      <Image source={require('@/assets/images/logo1.jpg')} style={styles.reactLogo} resizeMode="contain" />

      <Text style={styles.title}>University of Gwadar</Text>
      <Text style={styles.title2}>Bus Tracker, Reach At Time</Text>
      <Text style={styles.text}>Login with University Email</Text>

      <TextInput
        style={styles.input}
        placeholder="Email"
        placeholderTextColor="#888"
        value={email}
        onChangeText={setEmail}
      />
      <TextInput
        style={styles.input}
        placeholder="Password"
        placeholderTextColor="#888"
        secureTextEntry
        value={password}
        onChangeText={setPassword}
      />

      <TouchableOpacity style={styles.loginButton} onPress={handleLogin}>
        <Text style={styles.buttonText}>Login</Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    backgroundColor: 'white',
    padding: 20,
    color: 'black',
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  reactLogo: {
    height: 200,
    width: 200,
    marginRight: 26,
    marginBottom: 30,
  },
  title: {
    fontSize: 28,
    paddingBottom: 10,
    textAlign: 'center',
    color: '#1E3A8A', // Dark blue color
    fontWeight: 'bold',
  },
  title2: {
    fontSize: 18,
    paddingBottom: 10,
    textAlign: 'center',
    color: 'darkblue', // Dark blue color
    fontWeight: 'bold',
  },
  text: {
    fontSize: 16,
    textAlign: 'center',
    paddingBottom: 20,
    color: '#555',
  },
  input: {
    height: 45,
    width: '100%',
    borderColor: '#ccc',
    borderWidth: 1,
    borderRadius: 10,
    paddingHorizontal: 15,
    marginBottom: 15,
    fontSize: 16,
    backgroundColor: '#f9f9f9',
  },
  loginButton: {
    backgroundColor: '#1E3A8A', // Dark blue
    borderRadius: 10,
    paddingVertical: 12,
    paddingHorizontal: 20,
    width: '100%',
    alignItems: 'center',
    marginTop: 20,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowOffset: { width: 0, height: 5 },
    shadowRadius: 10,
  },
  buttonText: {
    color: 'white',
    fontSize: 18,
    fontWeight: 'bold',
  },
});
