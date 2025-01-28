import { StyleSheet, Image, Platform } from 'react-native';
import { Collapsible } from '@/components/Collapsible';
import ParallaxScrollView from '@/components/ParallaxScrollView';
import { ThemedText } from '@/components/ThemedText';
import { ThemedView } from '@/components/ThemedView';

const busData = [
  {
    id: 1,
    name: "Male Bus",
    route: "Gwadar ↔ University",
    timings: "Morning: 8:00 AM - 9:00 AM",
    driver: "Allah Bakhsh",
    contact: "+923223484512",
    capacity: 30,
    currentStatus: "On Schedule",
    image: require('@/assets/images/bus/bus2.jpg'), // Replace with actual image path
  },
  {
    id: 2,
    name: "Female Bus - Sur to University",
    route: "Sur ↔ University",
    timings: "Morning: 8:00 AM - 9:00 AM",
    driver: "Fatima Baloch",
    contact: "+923004567890",
    capacity: 35,
    currentStatus: "On Schedule",
    image: require('@/assets/images/bus/bus4.jpg'), // Replace with actual image path
  },
  {
    id: 3,
    name: "Female Bus - Pishukan to Gwadar",
    route: "Pishukan ↔ Gwadar",
    timings: "Morning: 7:00 AM - 8:30 AM, Evening: 4:00 PM - 5:30 PM",
    driver: "Ayesha Khan",
    contact: "+923005678910",
    capacity: 30,
    currentStatus: "On Schedule",
    image: require('@/assets/images/bus/bus3.jpg'), // Replace with actual image path
  },
  {
    id: 4,
    name: "Female Bus - Gwadar",
    route: "Gwadar ↔ University",
    timings: "Morning: 7:15 AM - 8:45 AM, Evening: 4:15 PM - 5:45 PM",
    driver: "Zahra Ali",
    contact: "+923006789101",
    capacity: 40,
    currentStatus: "On Schedule",
    image: require('@/assets/images/bus/bus5.jpg'), // Replace with actual image path
  },
  {
    id: 5,
    name: "Staff Van - Pishukan to Gwadar",
    route: "Pishukan ↔ Gwadar",
    timings: "Morning: 6:00 AM - 7:30 AM, Evening: 3:00 PM - 4:30 PM",
    driver: "Ahmed Shah",
    contact: "+923007891011",
    capacity: 15,
    currentStatus: "On Schedule",
    image: require('@/assets/images/bus/bus1.jpg'), // Replace with actual image path
  },
];

export default function TabTwoScreen() {
  return (
    <ParallaxScrollView
      headerBackgroundColor={{ light: '#D0D0D0', dark: '#353636' }}
      headerImage={
        <Image
          source={require('@/assets/images/logo1.jpg')} // Replace with actual header image
          style={styles.headerImage}
        />
      }>
      <ThemedView style={styles.titleContainer}>
        <ThemedText type="title">Bus Info</ThemedText>
      </ThemedView>

      {busData.map((bus) => (
        <Collapsible key={bus.id} title={bus.name}>
          <Image source={bus.image} style={styles.busImage} />
          <ThemedText>Route: {bus.route}</ThemedText>
          <ThemedText>Timings: {bus.timings}</ThemedText>
          <ThemedText>Driver: {bus.driver}</ThemedText>
          <ThemedText>Contact: {bus.contact}</ThemedText>
          <ThemedText>Capacity: {bus.capacity}</ThemedText>
          <ThemedText>Status: {bus.currentStatus}</ThemedText>
        </Collapsible>
      ))}
    </ParallaxScrollView>
  );
}

const styles = StyleSheet.create({
  headerImage: {
    width: '100%',
    height: 250,
    resizeMode: 'cover',
  },
  titleContainer: {
    flexDirection: 'row',
    gap: 8,
    paddingVertical: 16,
  },
  busImage: {
    width: '100%',
    height: 150,
    resizeMode: 'cover',
    borderRadius: 8,
    marginBottom: 8,
  },
});
