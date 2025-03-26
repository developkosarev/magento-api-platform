import Head from "next/head";
import { useEffect, useState } from "react";
import authProvider from './authProvider';

const Admin = () => {
  // Load the admin client-side
  const [DynamicAdmin, setDynamicAdmin] = useState(<p>Loading...</p>);
  useEffect(() => {
    (async () => {
      const { HydraAdmin, ResourceGuesser } = (await import("@api-platform/admin"));

      setDynamicAdmin(
        <HydraAdmin entrypoint={window.origin} authProvider={authProvider}>
          <ResourceGuesser name="store_websites" />
        </HydraAdmin>
      );
    })();
  }, []);

  return (
    <>
      <Head>
        <title>API Platform Admin (Magento)</title>
      </Head>

      {DynamicAdmin}
    </>
  );
};
export default Admin;
