import "xterm/css/xterm.css";
import type { Instance } from "@wasmer/sdk";
import { Terminal } from "xterm";
import { FitAddon } from "xterm-addon-fit";

async function main() {
    const { Wasmer, init, initializeLogger } = await import("@wasmer/sdk");
 
    await init();

    const term = new Terminal({ cursorBlink: true, convertEol: true });
    const fit = new FitAddon();
    term.loadAddon(fit);
    term.open(document.getElementById("terminal")!);
    fit.fit();
 
    const pkg = await Wasmer.fromRegistry("sharrattj/bash");
    term.writeln("Starting...");
 
    const instance = await pkg.entrypoint!.run();
    connectStreams(instance, term);

    const encoder = new TextEncoder();
 
function connectStreams(instance: Instance, term: Terminal) {
    const stdin = instance.stdin?.getWriter();
    term.onData(data => stdin?.write(encoder.encode(data)));
    instance.stdout.pipeTo(new WritableStream({ write: chunk => term.write(chunk) }));
    instance.stderr.pipeTo(new WritableStream({ write: chunk => term.write(chunk) }));
}
}