package com.BrewSoft.MachineControllerAPI.domain;

import java.io.IOException;
import java.net.InetSocketAddress;
import java.net.Socket;
import java.net.URI;
import java.net.URISyntaxException;
import java.util.List;
import java.util.concurrent.ExecutionException;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.eclipse.milo.opcua.sdk.client.OpcUaClient;
import org.eclipse.milo.opcua.sdk.client.api.config.OpcUaClientConfigBuilder;
import org.eclipse.milo.opcua.stack.client.DiscoveryClient;
import org.eclipse.milo.opcua.stack.core.UaException;
import org.eclipse.milo.opcua.stack.core.types.structured.EndpointDescription;

public class MachineConnection {

    private List<EndpointDescription> endpoints;
    private OpcUaClient client;
    private OpcUaClientConfigBuilder cfg;
    private String hostname;
    private int port;
    private URI uri;
    private Boolean status;

    public MachineConnection() {
    }

    public MachineConnection(String hostname, int port) {
        this.hostname = hostname;
        this.port = port;
        this.status = false;
    }

    public static boolean pingHost(String host, int port, int timeout) {
        try (Socket socket = new Socket()) {
            socket.connect(new InetSocketAddress(host, port), timeout);
            return true;
        } catch (IOException e) {
            return false; // Either timeout or unreachable or failed DNS lookup.
        }
    }

    public void connect() {
        if (pingHost(hostname, port, 3000)) {
            try {
                this.endpoints = DiscoveryClient.getEndpoints("opc.tcp://" + hostname + ":" + port).get();

                this.cfg = new OpcUaClientConfigBuilder();

                EndpointDescription original = this.endpoints.get(0);
                this.uri = new URI(original.getEndpointUrl()).parseServerAuthority();
                String endpointUrl = String.format(
                        "%s://%s:%s%s",
                        this.uri.getScheme(),
                        this.hostname,
                        this.uri.getPort(),
                        this.uri.getPath()
                );

                EndpointDescription endpoint = new EndpointDescription(endpointUrl,
                        original.getServer(),
                        original.getServerCertificate(),
                        original.getSecurityMode(),
                        original.getSecurityPolicyUri(),
                        original.getUserIdentityTokens(),
                        original.getTransportProfileUri(),
                        original.getSecurityLevel());

                this.cfg.setEndpoint(endpoint);
                
                this.client = OpcUaClient.create(this.cfg.build());
                this.client.connect().get();
                
            } catch (UaException ex) {
                System.out.println("UA Exception");
                Logger.getLogger(MachineConnection.class.getName()).log(Level.SEVERE, null, ex);
            } catch (InterruptedException ex) {
                System.out.println("interrupt");
                Logger.getLogger(MachineConnection.class.getName()).log(Level.SEVERE, null, ex);
            } catch (ExecutionException ex) {
                System.out.println("execute");
                Logger.getLogger(MachineConnection.class.getName()).log(Level.SEVERE, null, ex);
            } catch (URISyntaxException ex) {
                System.out.println("URI");
                Logger.getLogger(MachineConnection.class.getName()).log(Level.SEVERE, null, ex);
            }
            this.status = true;
        } else {
            // SERVER NOT AVAILABLE
            this.status = false;
        }
    }

    public OpcUaClient getClient() {
        return this.client;
    }

    public Boolean getStatus() {
        return status;
    }
}
