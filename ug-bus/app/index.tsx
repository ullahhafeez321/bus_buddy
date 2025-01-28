// app/index.tsx (This will be the default screen, which can redirect to login)
import { Redirect } from 'expo-router';

export default function IndexPage() {

  // Automatically redirect to login page when the app starts
  return <Redirect href="/login" />;
}
