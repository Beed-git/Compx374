package com.google.ar.core.examples.java.webapi;

import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.Future;

public class WebApiThread {
    private ExecutorService executorService;
    private WebApi webApi;

    private WebApiThread() {
        this.executorService = Executors.newSingleThreadExecutor();
        this.webApi = new WebApi();
    }

    public synchronized <T> Future<T> get(String uri, String accessToken, Class<T> tClass) throws Exception {
        return executorService.submit(() -> webApi.get(uri, accessToken, tClass));
    }

    private static WebApiThread instance;

    public static WebApiThread getInstance() {
        if (instance == null) {
            instance = new WebApiThread();
        }
        return instance;
    }
}
