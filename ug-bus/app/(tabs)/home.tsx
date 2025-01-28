import React, { useState, useEffect } from 'react';
import { Image, StyleSheet, Alert, View, ActivityIndicator, TouchableOpacity, Text } from 'react-native';
import { useRouter } from 'expo-router';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Icon from 'react-native-vector-icons/MaterialIcons';
import axios from 'axios';
import * as Location from 'expo-location'; // Import Location API

export default function HomeScreen() { 
  const [userRole, setUserRole] = useState(null);
  const [loading, setLoading] = useState(true);
  const router = useRouter();
  const [sharing, setSharing] = useState(false);
  const [locationSubscription, setLocationSubscription] = useState(null); // Store the subscription

  useEffect(() => {
    const fetchUserRole = async () => {
      try {
        const role = await AsyncStorage.getItem('userRole');
        if (role) {
          setUserRole(role);
        } else {
          Alert.alert('Error', 'No user role found. Please log in again.');
          router.replace('/login');
        }
      } catch (error) {
        console.error('Error fetching user role:', error);
        Alert.alert('Error', 'Failed to retrieve user role.');
        router.replace('/login');
      } finally {
        setLoading(false);
      }
    };

    fetchUserRole();
  }, []);

  const handleLogout = async () => {
    try {
      await AsyncStorage.removeItem('userRole');
      await AsyncStorage.removeItem('authToken');
      router.replace('/login');
      Alert.alert('Logged out successfully');
    } catch (error) {
      console.error('Error during logout:', error);
      Alert.alert('Error', 'Failed to log out');
    }
  };

  const startSharingLocation = async () => {
    const { status } = await Location.requestForegroundPermissionsAsync();
    if (status !== 'granted') {
      Alert.alert('Permission Denied', 'Location permission is required to share your location.');
      return;
    }

    setSharing(true);

    const subscription = await Location.watchPositionAsync(
      {
        accuracy: Location.Accuracy.High,
        timeInterval: 5000, // Update every 5 seconds
        distanceInterval: 10, // Update if moved by 10 meters
      },
      async (location) => {
        const { latitude, longitude } = location.coords;
        try {
          await axios.post('http://192.168.25.161:8000/api/update-location', {
            latitude,
            longitude,
          });
          console.log('Location shared successfully:', { latitude, longitude });
        } catch (error) {
          console.error('Error sharing location:', error);
          Alert.alert('Error', 'Failed to share location.');
        }
      }
    );

    setLocationSubscription(subscription); // Save the subscription object to stop it later
  };

  const stopSharingLocation = () => {
    if (locationSubscription) {
      locationSubscription.remove(); // Stop the location tracking
      setLocationSubscription(null); // Clear the subscription
      setSharing(false); // Update state to indicate sharing has stopped
      Alert.alert('Stopped sharing location.');
      console.log('stopped location sharing');
    }
  };

  if (loading) {
    return (
      <View style={styles.loaderContainer}>
        <ActivityIndicator size="large" color="#1E3A8A" />
        <Text style={styles.loadingText}>Loading...</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <Image
        source={require('@/assets/images/logo1.jpg')}
        style={styles.reactLogo}
        resizeMode="contain"
      />

      <View style={styles.titleContainer}>
        <Text style={styles.title}>University of Gwadar</Text>
        <Text style={styles.subtitle}>Bus Tracker</Text>
      </View>

      <View style={styles.stepContainer}>
        {userRole === 'driver' ? (
          <>
            {!sharing ? (
              <TouchableOpacity
                style={[styles.customButton, styles.driverButton]}
                onPress={startSharingLocation}
              >
                <Text style={styles.buttonText}>Share Location</Text>
              </TouchableOpacity>
            ) : (
              <TouchableOpacity
                style={[styles.customButton, styles.stopButton]}
                onPress={stopSharingLocation}
              >
                <Text style={styles.buttonText}>Stop Sharing Location</Text>
              </TouchableOpacity>
            )}
          </>
        ) : userRole === 'student' ? (
          <TouchableOpacity
            style={[styles.customButton, styles.studentButton]}
            onPress={() => router.replace('/map')}
          >
            <Text style={styles.buttonText}>Show Map</Text>
          </TouchableOpacity>
        ) : (
          <Text style={styles.errorText}>Invalid user role</Text>
        )}
      </View>

      <View style={styles.logoutContainer}>
        <TouchableOpacity style={styles.logoutButton} onPress={handleLogout}>
          <Icon name="logout" size={24} color="#EF4444" style={styles.logoutIcon} />
          <Text style={styles.logoutText}>Logout</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#F9FAFB',
    paddingHorizontal: 20,
  },
  loaderContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#F9FAFB',
  },
  loadingText: {
    fontSize: 18,
    marginTop: 10,
    color: '#1E3A8A',
  },
  titleContainer: {
    alignItems: 'center',
    marginBottom: 40,
  },
  title: {
    fontSize: 32,
    fontWeight: 'bold',
    color: '#1E3A8A',
    textAlign: 'center',
    marginBottom: 5,
  },
  subtitle: {
    fontSize: 22,
    fontWeight: '600',
    color: '#1E3A8A',
    textAlign: 'center',
  },
  reactLogo: {
    height: 180,
    width: 300,
    padding: 150,
    marginBottom: 20,
    borderRadius: 15,
  },
  stepContainer: {
    marginTop: 16,
    gap: 8,
    marginBottom: 24,
    width: '100%',
    alignItems: 'center',
  },
  customButton: {
    paddingVertical: 12,
    paddingHorizontal: 24,
    borderRadius: 10,
    alignItems: 'center',
    justifyContent: 'center',
    elevation: 3,
    marginBottom: 10,
    width: '80%',
  },
  driverButton: {
    backgroundColor: 'darkblue',
  },
  studentButton: {
    backgroundColor: 'darkblue',
  },
  buttonText: {
    fontSize: 18,
    color: 'white',
    fontWeight: 'bold',
  },
  errorText: {
    color: '#EF4444',
    fontSize: 16,
    textAlign: 'center',
  },
  logoutContainer: {
    marginTop: 10,
    paddingVertical: 10,
    paddingHorizontal: 20,
    backgroundColor: 'white',
    borderRadius: 50,
    shadowColor: '#000',
    shadowOpacity: 0.2,
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 5,
    elevation: 10,
    alignItems: 'center',
  },
  logoutButton: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 20,
  },
  logoutIcon: {
    color: 'darkblue',
    marginRight: 10,
  },
  logoutText: {
    color: 'darkblue',
    fontSize: 16,
    fontWeight: '600',
  },
  stopButton: {
    backgroundColor: 'red',
  },
});
