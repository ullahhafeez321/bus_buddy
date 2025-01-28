import React, { useState, useEffect } from 'react';
import { Alert, View, Text, TouchableOpacity, ActivityIndicator } from 'react-native';
import MapView, { Marker, Circle } from 'react-native-maps';
import axios from 'axios';
import * as Location from 'expo-location';
import { router } from 'expo-router';

export default function MapPage() {
  const [driverLocation, setDriverLocation] = useState(null);
  const [userLocation, setUserLocation] = useState(null);
  const [loading, setLoading] = useState(true);
  const [region, setRegion] = useState(null);

  // Fetch user location once and lock the region
  useEffect(() => {
    const fetchUserLocation = async () => {
      const { status } = await Location.requestForegroundPermissionsAsync();
      if (status !== 'granted') {
        Alert.alert('Permission Denied', 'Location permission is required.');
        setLoading(false);
        return;
      }

      try {
        const location = await Location.getCurrentPositionAsync({
          accuracy: Location.Accuracy.BestForNavigation,
        });

        console.log('Location:', location.coords.latitude, location.coords.longitude);
        if (location && location.coords) {
          setUserLocation({
            latitude: location.coords.latitude,
            longitude: location.coords.longitude,
          });

          setRegion({
            latitude: location.coords.latitude,
            longitude: location.coords.longitude,
            latitudeDelta: 0.01,
            longitudeDelta: 0.01,
          });
        } else {
          console.warn('Location data missing or invalid');
        }
      } catch (error) {
        Alert.alert('Error', 'Unable to fetch your location.');
      } finally {
        setLoading(false);
      }
    };

    fetchUserLocation();
  }, []);

  // Fetch driver location every 5 seconds
  useEffect(() => {
    const fetchDriverLocation = async () => {
      try {
        const response = await axios.get('http://192.168.25.161:8000/api/driver-location');
        if (response.data.latitude && response.data.longitude) {
          setDriverLocation({
            latitude: response.data.latitude,
            longitude: response.data.longitude,
          });
        } else {
          // console.log(response.data.latitude);
          // console.warn('Invalid driver location received');
        }
      } catch (error) {
        console.error('Failed to fetch driver location', error);
      }
    };

    const intervalId = setInterval(fetchDriverLocation, 5000); // Poll every 5 seconds
    return () => clearInterval(intervalId); // Cleanup
  }, []);

  if (loading) {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <ActivityIndicator size="large" color="#0000ff" />
        <Text style={{ color: 'white' }}>Loading map...</Text>
      </View>
    );
  }

  const backFunc = () => {
    router.replace('/home');
  };

  const defaultRegion = {
    latitude: 25.185652759019316, // Fallback location
    longitude: 62.34443943986793,
    latitudeDelta: 0.01,
    longitudeDelta: 0.01,
  };

  return (
    <View style={{ flex: 1 }}>
      <MapView
        style={{ flex: 1 }}
        region={region || defaultRegion} // Lock to region
        showsUserLocation={true} // Show user location on map
        followsUserLocation={false} // Disable auto-follow to stabilize the view
        onMapReady={() => console.log('Map loaded')}
      >
        {/* University Third Block Marker */}
        <Marker
          coordinate={{
            latitude: 25.185652759019316,
            longitude: 62.34443943986793,
          }}
          title="University Third Block"
          description="Location of the university's third block."
          pinColor="green"
        />

        {/* University of Gwadar Main Block Marker */}
        <Marker
          coordinate={{
            latitude: 25.189519732936834,
            longitude: 62.31404624626295,
          }}
          title="University of Gwadar Main Block"
          description="Location of the main block of the University of Gwadar."
          pinColor="blue"
        />

        {/* Driver Location as a Live Circle */}
        {driverLocation && driverLocation.latitude && driverLocation.longitude && (
          <Circle
            center={{
              latitude: driverLocation.latitude,
              longitude: driverLocation.longitude,
            }}
            radius={20} // Fixed radius
            strokeColor="rgba(255,0,0,0.5)"
            fillColor="rgba(255,0,0,0.3)"
          />
        )}

        {/* User Location as a Custom Circle */}
        {userLocation && userLocation.latitude && userLocation.longitude && (
          <Circle
            center={userLocation}
            radius={30} // Fixed radius for accuracy circle
            strokeColor="rgba(0,0,255,0.5)"
            fillColor="rgba(0,0,255,0.3)"
          />
        )}
      </MapView>

      {/* Back Button */}
      <TouchableOpacity
        style={{
          position: 'absolute',
          top: 50,
          left: 10,
          padding: 10,
          backgroundColor: 'rgba(0, 0, 0, 0.5)',
          borderRadius: 5,
        }}
        onPress={backFunc}
      >
        <Text style={{ color: 'white', fontSize: 16 }}>Back</Text>
      </TouchableOpacity>
    </View>
  );
}
